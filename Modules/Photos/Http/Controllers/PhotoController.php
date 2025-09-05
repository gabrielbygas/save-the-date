<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Photos\Models\Photo;
use Modules\Photos\Models\Album;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class PhotoController extends Controller
{
    public function create($slug) // creer ou ajouter des photos dans un album
    {
        $album = Album::where('slug', $slug)->firstOrFail(); // utilise le slug pour trouver l'album
        return view('photos::photos.create', compact('album'));
    }

    public function index($slug)  // afficher toutes les photos d'un album
    {
        $album = Album::where('slug', $slug)->firstOrFail(); // utilise le slug pour trouver l'album
        $photos = Photo::where('album_id', $album->id)->get();
        return view('photos::photos.index', compact('photos', 'album'));
    }

    public function show($slug, $id) // afficher une seule photo d'un album
    {
        // Trouve l'album en utilisant son slug. Si l'album n'est pas trouvé, une erreur 404 est levée.
        $album = Album::where('slug', $slug)->firstOrFail();

        // Trouve la photo en utilisant son ID et s'assure qu'elle appartient à l'album.
        // Si la photo n'est pas trouvée ou n'appartient pas à l'album, une erreur 404 est levée.
        $photo = Photo::where('id', $id)
            ->where('album_id', $album->id)
            ->firstOrFail();

        // Passe la photo unique et l'album à la vue pour l'affichage.
        return view('photos::photos.show', compact('photo', 'album'));
    }

    public function store(Request $request, $slug) // utilise $slug au lieu de $albumId
    {
        $validated = $request->validate([
            'photos'        => 'required|image|max:10240', // max 10MB
            'thumb_path'   => 'nullable|string|max:255',
            'exif_json'    => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();

        // Upload plusieurs photos
        foreach ($request->file('photos') as $photo) {
            $path = $photo->store("albums/{$album->slug}/", 'public'); // Stocke dans storage/app/public/albums/slug/
            $validated['thumb_path'] = $this->createThumbnail($path, $album->slug);
            $validated['file_name'] = $this->makeUniqueFileName($photo, $album->slug);

            // Gather metadata
            $photoData = [
                'original_path' => $path,
                'file_name'     => $validated['file_name'],
                'thumb_path'    => $validated['thumb_path'] ?? null,
                'size_bytes'    => $photo->getSize(),
                'mime'          => $photo->getMimeType(),
                'exif_json'     => $validated['exif_json'] ?? null,
                'uploaded_ip'   => $request->ip(),
            ];

            $album->photos()->create($photoData);
        }

        return redirect()->route('photos.show', $album->slug)
            ->with('success', 'Photo ajoutée avec succès.');
    }

    /**
     * Update photo metadata.
     */
    public function update(Request $request, $albumId, $photoId)
    {
        $validated = $request->validate([
            'thumb_path'   => 'nullable|string|max:255',
            'exif_json'    => 'nullable|json',
        ]);

        $album = Album::findOrFail($albumId);
        $photo = $album->photos()->findOrFail($photoId);

        $photo->update([
            'thumb_path' => $validated['thumb_path'] ?? $photo->thumb_path,
            'exif_json'  => $validated['exif_json'] ?? $photo->exif_json,
        ]);

        return redirect()->route('albums.show', $albumId)
            ->with('success', 'Photo mise à jour avec succès.');
    }

    /**
     * Remove a photo from an album.
     */
    public function destroy($albumId, $photoId)
    {
        $album = Album::findOrFail($albumId);
        $photo = $album->photos()->findOrFail($photoId);

        // Delete file from storage
        if ($photo->original_path && Storage::disk('public')->exists($photo->original_path)) {
            Storage::disk('public')->delete($photo->original_path);
        }

        $photo->delete();

        return redirect()->route('albums.show', $albumId)
            ->with('success', 'Photo supprimée avec succès.');
    }

    // makeUniqueFileName function en utilisant le slug de l'album (ex : doe_john_1.jpg, doe_john_2.jpg, etc.)
    private function makeUniqueFileName($photo, $albumSlug)
    {
        $count = 1;
        $extension = $photo->getClientOriginalExtension();
        // tant que le nom de fichier existe, on incrémente le compteur
        while (Photo::where('file_name', $albumSlug . '_' . $count . '.' . $extension)->exists()) {
            $count++;
        }
        return $albumSlug . '_' . $count . '.' . $extension;
    }


    /**
     * Crée une miniature d'une photo et la stocke.
     *
     * @param  string  $originalPhotoPath Le chemin de la photo originale.
     * @param string $slug Le slug de l'album pour nommer la miniature.
     * @return string Le chemin de la miniature créée.
     */
    private function createThumbnail(string $originalPhotoPath, string $slug): string
    {
        // Vérifier que le fichier original existe
        if (!Storage::disk('public')->exists($originalPhotoPath)) {
            throw new \Exception("Le fichier original n'existe pas : {$originalPhotoPath}");
        }

        // Charger l'image avec Intervention Image
        $image = Image::make(Storage::disk('public')->path($originalPhotoPath));

        // Redimensionner à 150x150 sans déformer ni agrandir
        $image->fit(150, 150, function ($constraint) {
            $constraint->upsize();
        });

        // Définir le dossier et le nom du fichier miniature
        $thumbDirectory = "thumbs/{$slug}";
        $thumbFileName = pathinfo($originalPhotoPath, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbPath = "{$thumbDirectory}/{$thumbFileName}";

        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('public')->exists($thumbDirectory)) {
            Storage::disk('public')->makeDirectory($thumbDirectory);
        }

        // Sauvegarder la miniature en JPEG optimisé
        Storage::disk('public')->put($thumbPath, (string) $image->encode('jpg', 80));

        return $thumbPath;
    }
}