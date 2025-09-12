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
use Symfony\Component\HttpFoundation\StreamedResponse;
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
            'photos.*'    => 'image|max:10240', // 10 MB max
            'category'    => 'nullable|in:civil,religieux,coutumier,reception,autre',
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();

        foreach ($request->file('photos') as $file) {
            try {
                // Nom unique
                $fileName = $this->makeUniqueFileName($file, $album->slug);

                // Stocker dans storage/private (sécurisé)
                $path = $file->storeAs("private/albums/{$album->slug}", $fileName, 'private');

                // Créer miniature
                $thumbPath = $this->createThumbnail($path, $album->slug);

                // Métadonnées
                $photoData = [
                    'original_path' => $path,
                    'file_name'     => $fileName,
                    'thumb_path'    => $thumbPath,
                    'size_bytes'    => $file->getSize(),
                    'mime'          => $file->getMimeType(),
                    'category'      => $request->category ?? 'autre',
                    'exif_json'     => $request->exif_json,
                    'uploaded_ip'   => $request->ip(),
                ];

                $album->photos()->create($photoData);
            } catch (\Exception $e) {
                Log::error("Erreur lors de l'upload : " . $e->getMessage());
                continue;
            }
        }

        return redirect()->route('photos.index', $album->slug)
            ->with('success', 'Photo(s) ajoutée(s) avec succès.');
    }

    /**
     * Formulaire pour les invités (via token).
     */
    public function createWithToken($slug, $token)
    {
        $uploadToken = UploadToken::where('token', $token)
            ->where('album_id', Album::where('slug', $slug)->firstOrFail()->id)
            ->where('used', false)
            ->firstOrFail();

        return view('photos::photos.upload_with_token', compact('uploadToken'));
    }

    /**
     * Stocke une photo via un token d'invité.
     */
    public function storeWithToken(Request $request, $slug, $token)
    {
        $request->validate([
            'photo'       => 'required|image|max:10240',
            'guest_name'  => 'nullable|string|max:100',
        ]);

        $uploadToken = UploadToken::where('token', $token)
            ->where('album_id', Album::where('slug', $slug)->firstOrFail()->id)
            ->where('used', false)
            ->where('expires_at', '>', now()) // Vérifie que le token n'est pas expiré
            ->firstOrFail();

        $album = $uploadToken->album;
        $file = $request->file('photo');

        try {
            // Nom unique
            $fileName = $this->makeUniqueFileName($file, $album->slug);

            // Stocker dans storage/private
            $path = $file->storeAs("private/albums/{$album->slug}", $fileName, 'private');

            // Créer miniature
            $thumbPath = $this->createThumbnail($path, $album->slug);

            // Métadonnées
            $photoData = [
                'original_path' => $path,
                'file_name'     => $fileName,
                'thumb_path'    => $thumbPath,
                'size_bytes'    => $file->getSize(),
                'mime'          => $file->getMimeType(),
                'category'      => 'invite', // Catégorie spéciale pour les invités
                'exif_json'     => null,
                'uploaded_ip'   => $request->ip(),
                'guest_name'    => $request->guest_name ?? 'Invité',
            ];

            $album->photos()->create($photoData);

            // Marquer le token comme utilisé
            $uploadToken->update(['used' => true]);

            return redirect()->route('albums.share', $album->share_url_token)
                ->with('success', 'Merci ! Votre photo a été ajoutée à l\'album.');
        } catch (\Exception $e) {
            Log::error("Erreur upload invité : " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
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

        return redirect()->route('photos.index', $album->slug)
            ->with('success', 'Photo supprimée avec succès.');
    }

    /**
     * Génère un nom de fichier unique.
     */
    private function makeUniqueFileName($file, $albumSlug): string
    {
        $extension = $file->getClientOriginalExtension();
        return $albumSlug . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
    }

    /**
     * Crée une miniature d'une photo.
     */
    private function createThumbnail(string $originalPhotoPath, string $slug): string
    {
        if (!Storage::disk('private')->exists($originalPhotoPath)) {
            throw new \Exception("Fichier introuvable : {$originalPhotoPath}");
        }

        $image = Image::read(Storage::disk('private')->path($originalPhotoPath))
            ->cover(300, 300);

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
     * Sert une photo de manière sécurisée (vérifie le token).
     */
    public function serve($slug, $photoId, $token): StreamedResponse
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        // Vérifier que le token correspond à l'album
        if ($album->share_url_token !== $token) {
            abort(403, 'Token invalide.');
        }
        // Vérifier la date de stockage
        if (now()->gt($album->storage_until_at)) {
            abort(403, 'La période de stockage de cet album est terminée.');
        }

        $photo = $album->photos()->findOrFail($photoId);

        // Log l'accès
        AlbumAccessLog::create([
            'album_id'   => $album->id,
            'photo_id'   => $photo->id,
            'visitor_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);


        $path = Storage::disk('private')->path($photo->original_path);

        return new StreamedResponse(function () use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
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
}