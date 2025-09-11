<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Photos\Models\Photo;
use Modules\Photos\Models\Album;
use Illuminate\Support\Str;
//use Intervention\Image\Facades\Image;
use Intervention\Image\Laravel\Facades\Image;



class PhotoController extends Controller
{
    public function create($slug) // creer ou ajouter des photos dans un album
    {
        $album = Album::where('slug', $slug)->firstOrFail(); // utilise le slug pour trouver l'album
        return view('photos::photos.create', compact('album'));
    }

    public function index($slug)  // afficher toutes les photos d'un album
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photos = $album->photos()->latest()->get();
        // renvoyer aussi le client Mr name ane Mrs name
        $client = $album->client;

        return view('photos::photos.index', compact('photos', 'album', 'client'));
    }

    public function show($slug, $id) // afficher une seule photo d'un album
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->where('id', $id)->firstOrFail();

        return view('photos::photos.show', compact('photo', 'album'));
    }

    // Stocke une ou plusieurs photos
    public function store(Request $request, $slug)
    {
        $validated = $request->validate([
            'photos'      => 'required|array',
            'photos.*'    => 'image|max:10240', // 10 MB max
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();

        foreach ($request->file('photos') as $file) {
            // Nom unique
            $fileName = $this->makeUniqueFileName($file, $album->slug);

            // Enregistrement du fichier
            $path = $file->storeAs("albums/{$album->slug}", $fileName, 'public');

            // Créer miniature
            $thumbPath = $this->createThumbnail($path, $album->slug);

            // Métadonnées
            $photoData = [
                'original_path' => $path,
                'file_name'     => $fileName,
                'thumb_path'    => $thumbPath,
                'size_bytes'    => $file->getSize(),
                'mime'          => $file->getMimeType(),
                'exif_json'     => $validated['exif_json'] ?? null,
                'uploaded_ip'   => $request->ip(),
            ];

            $album->photos()->create($photoData);
        }

        return redirect()->route('photos.index', $album->slug)
            ->with('success', 'Photo(s) ajoutée(s) avec succès.');
    }

    /**
     * Update photo metadata.
     */
    public function update(Request $request, int $albumId, int $photoId)
    {
        $request->validate([
            'thumb_path' => 'nullable|string|max:255',
            'exif_json'  => 'nullable|json',
        ]);

        $album = Album::findOrFail($albumId);
        $photo = $album->photos()->findOrFail($photoId);

        $photo->update([
            'thumb_path' => $request->input('thumb_path', $photo->thumb_path),
            'exif_json'  => $request->input('exif_json', $photo->exif_json),
        ]);

        return redirect()->route('albums.show', $album->slug)
            ->with('success', 'Photo mise à jour avec succès.');
    }

    /**
     * Remove a photo from an album.
     */
    public function destroy($slug, $photoId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->findOrFail($photoId);

        // Supprimer photo originale
        if ($photo->original_path && Storage::disk('public')->exists($photo->original_path)) {
            Storage::disk('public')->delete($photo->original_path);
        }

        // Supprimer miniature
        if ($photo->thumb_path && Storage::disk('public')->exists($photo->thumb_path)) {
            Storage::disk('public')->delete($photo->thumb_path);
        }

        $photo->delete();

        return redirect()->route('photos.index', $album->slug)
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
    public function createThumbnail($originalPhotoPath, $slug)
    {
        if (!Storage::disk('public')->exists($originalPhotoPath)) {
            throw new \Exception("Fichier introuvable : {$originalPhotoPath}");
        }

        // ✅ En v3, on utilise `read()` et `cover()`
        $image = Image::read(Storage::disk('public')->path($originalPhotoPath))
            ->cover(300, 300);

        $thumbDirectory = "thumbs/{$slug}";
        $thumbFileName = pathinfo($originalPhotoPath, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbPath = "{$thumbDirectory}/{$thumbFileName}";

        if (!Storage::disk('public')->exists($thumbDirectory)) {
            Storage::disk('public')->makeDirectory($thumbDirectory);
        }

        $image->save(Storage::disk('public')->path($thumbPath));

        return $thumbPath;
    }
}
