<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Photos\Models\Photo;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Modules\Photos\Models\AlbumAccessLog;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class PhotoController extends Controller
{
    /**
     * Affiche le formulaire pour ajouter des photos à un album.
     */
    public function create($slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        return view('photos::photos.create', compact('album'));
    }

    /**
     * Affiche toutes les photos d'un album, filtrées par catégorie.
     */
    public function index(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $client = $album->client;

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        // Filtre par catégorie si spécifié
        $category = $request->get('category');
        $query = $album->photos()->latest();

        if ($category) {
            $query->where('category', $category);
        }

        $photos = $query->get();
        //$photos = $query->paginate(20); // Pagination
        $categories = Photo::select('category')->where('album_id', $album->id)
            ->groupBy('category')
            ->pluck('category');

        return view('photos::photos.index', compact('photos', 'album', 'client', 'categories', 'category'));
    }

    /**
     * Affiche une photo spécifique.
     */
    public function show($slug, $id)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->findOrFail($id);

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        // Log l'accès à la photo
        AlbumAccessLog::create([
            'album_id'   => $album->id,
            'photo_id'   => $photo->id,
            'visitor_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('photos::photos.show', compact('photo', 'album'));
    }

    /**
     * Stocke une ou plusieurs photos dans un album (pour le propriétaire).
     */
    public function store(Request $request, $slug)
    {
        $request->validate([
            'photos'      => 'required|array',
            'photos.*'    => 'image|max:10240',
            'category'    => 'nullable|in:civil,religieux,coutumier,reception,autre',
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();
        $directory = "albums/{$album->slug}";

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('private')->exists($directory)) {
            Storage::disk('private')->makeDirectory($directory);
        }

        $successCount = 0;
        foreach ($request->file('photos') as $file) {
            DB::beginTransaction();
            try {
                $fileName = $this->makeUniqueFileName($file, $album->slug); // Génère un nom de fichier unique
                $path = $file->storeAs($directory, $fileName, 'private'); // Chemin relatif

                if (!Storage::disk('private')->exists($path)) { // Vérification du stockage
                    throw new \Exception("Le fichier n'a pas été stocké.");
                }

                $thumbPath = $this->createThumbnail($path, $album->slug); // Crée la miniature

                $photoData = [
                    'original_path' => $directory . '/' . $fileName, // Chemin relatif,
                    'file_name'     => $fileName,
                    'thumb_path'    => $thumbPath,
                    'size_bytes'    => $file->getSize(),
                    'mime'          => $file->getMimeType(),
                    'category'      => $request->category ?? 'autre',
                    'exif_json'     => $request->exif_json,
                    'uploaded_ip'   => $request->ip(),
                ];

                $photo = $album->photos()->create($photoData);
                Log::info("Photo créée avec ID : " . $photo->id);

                // Log l'accès
                AlbumAccessLog::create([
                    'album_id'   => $album->id,
                    'photo_id'   => $photo->id,
                    'visitor_ip' => request()->ip(),
                    'action'     => 'upload',
                    'user_agent' => request()->userAgent(),
                ]);

                DB::commit();
                $successCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur lors de l'upload de {$file->getClientOriginalName()} : " . $e->getMessage());
                continue;
            }
        }

        if ($successCount > 0) { // Au moins une photo a été uploadée avec succès
            return redirect()->route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token])
                ->with('success', "{$successCount} photo(s) ajoutée(s) avec succès.");
        } else { // Aucune photo n'a pu être uploadée
            return back()->with('error', 'Aucune photo n\'a pu être ajoutée. Vérifiez les fichiers et réessayez.');
        }
    }

    /**
     * Sert une photo (pour le propriétaire).
     */
    public function servePhoto($slug, $filename)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->where('file_name', $filename)->firstOrFail();
        $path = $photo->original_path; // Utilise le chemin enregistré en base

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);


        if (!Storage::disk('private')->exists($path)) {
            Log::error("Fichier introuvable : {$path}");
            abort(404, 'Photo introuvable.');
        }

        return response()->file(Storage::disk('private')->path($path));
    }



    /**
     * Met à jour les métadonnées d'une photo.
     */
    public function update(Request $request, $slug, $photoId)
    {
        $request->validate([
            'category'    => 'nullable|in:civil,religieux,coutumier,reception,autre,invite',
            'caption'     => 'nullable|string|max:255',
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->findOrFail($photoId);

        $photo->update([
            'category'    => $request->category ?? $photo->category,
            'caption'     => $request->caption ?? $photo->caption,
            'exif_json'   => $request->exif_json ?? $photo->exif_json,
        ]);

        return redirect()->route('photos.show', [$album->slug, $photo->id])
            ->with('success', 'Photo mise à jour avec succès.');
    }

    /**
     * Supprime une photo.
     */
    public function destroy($slug, $photoId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $photo = $album->photos()->findOrFail($photoId);

        // Supprimer photo originale
        if ($photo->original_path && Storage::disk('private')->exists($photo->original_path)) {
            Storage::disk('private')->delete($photo->original_path);
        }

        // Supprimer miniature
        if ($photo->thumb_path && Storage::disk('private')->exists($photo->thumb_path)) {
            Storage::disk('private')->delete($photo->thumb_path);
        }

        $photo->delete();

        return redirect()->route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token])
            ->with('success', 'Photo supprimée avec succès.');
    }

    /**
     * Génère un nom de fichier unique avec validation d'extension.
     */
    private function makeUniqueFileName($file, $albumSlug): string
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions)) {
            $extension = $file->guessExtension() ?? 'jpg';
        }

        return $albumSlug . '_' . Str::random(16) . '.' . $extension;
    }

    /**
     * Crée une miniature d'une photo.
     */
    private function createThumbnail(string $originalPhotoPath, string $slug): string
    {
        if (!Storage::disk('private')->exists($originalPhotoPath)) {
            throw new \Exception("Fichier introuvable : {$originalPhotoPath}");
        }

        try {
            $image = Image::read(Storage::disk('private')->path($originalPhotoPath))
                ->cover(300, 300);
        } catch (\Exception $e) {
            throw new \Exception("Impossible de créer la miniature : " . $e->getMessage());
        }


        $thumbDirectory = "private/thumbs/{$slug}";
        $thumbFileName = pathinfo($originalPhotoPath, PATHINFO_FILENAME) . '_thumb.jpg';
        $thumbPath = "{$thumbDirectory}/{$thumbFileName}";

        if (!Storage::disk('private')->exists($thumbDirectory)) {
            Storage::disk('private')->makeDirectory($thumbDirectory);
        }

        $image->save(Storage::disk('private')->path($thumbPath));
        return $thumbPath;
    }

    /**
     * Télécharge toutes les photos d'un album en ZIP.
     */
    public function downloadAll($slug, $token)
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        if ($album->share_url_token !== $token) {
            abort(403, 'Token invalide.');
        }

        // Vérifier la taille totale
        $totalSize = $album->photos->sum('size_bytes');
        if ($totalSize > 500 * 1024 * 1024) { // 500 Mo max
            abort(403, 'La taille totale des photos dépasse la limite autorisée pour le téléchargement.');
        }

        $zip = new ZipArchive();
        $zipFileName = "album_{$album->slug}.zip";
        $zipPath = sys_get_temp_dir() . '/' . $zipFileName;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($album->photos as $photo) {
                $filePath = Storage::disk('private')->path($photo->original_path);
                $zip->addFile($filePath, $photo->file_name);
            }
            $zip->close();

            return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
        } else {
            abort(500, 'Impossible de créer le ZIP.');
        }
    }

    /**
     * Check AlbumStorage date and payment status
     */
    private function checkActiveAlbumStorage(Album $album)
    {   
        if (now()->gt($album->storage_until_at)) {
            abort(403, 'La période de stockage de cet album est terminée.');
        }
        // Vérifie si l'album est actif
        // if ($album->status !== 'active') {
            //abort(403, 'Cet album n\'est pas activé. Veuillez effectuer le paiement.');
        //}
    }
}       