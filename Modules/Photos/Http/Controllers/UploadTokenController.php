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

class UploadTokenController extends Controller
{
    /**
     * Affiche la liste des tokens d'upload pour un album.
     */
    public function index($slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $tokens = $album->uploadTokens()->latest()->get();
        //$tokens = $album->uploadTokens()->latest()->paginate(20);
        return view('photos::upload_tokens.index', compact('album', 'tokens'));
    }

    /**
     * Formulaire pour les invités (via token).
     */
    public function create($slug, $token)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $uploadToken = $album->uploadTokens()
            ->where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', now()) // Vérifie que le token n'est pas expiré
            ->firstOrFail();

        return view('photos::photos.upload_token', compact('uploadToken', 'album'));
    }

    /**
     * Stocke une photo via un token d'invité.
     */
    public function store(Request $request, $slug, $token)
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
                'guest_name'    => $request->guest_name ?? $uploadToken->visitor_name ?? 'Invité',
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
     * Sert une photo de manière sécurisée (vérifie le token).
     */
    public function serve($slug, $photoId, $token): StreamedResponse
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        // Vérifier que le token d'upload est valide
        $uploadToken = $album->uploadTokens()
            ->where('token', $token)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // Vérifier la date de stockage de l'album
        if (now()->gt($album->storage_until_at)) {
            abort(403, 'La période de stockage de cet album est terminée.');
        }
        
        // reste a decider si on serve une seule photo ou toutes les photos
        // pour l'instant on sert une seule photo. Pour toutes les photos:$photos = $album->photos();
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
     * Supprime un token d'upload.
     */
    public function destroy($slug, $tokenId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $token = $album->uploadTokens()->findOrFail($tokenId);

        // Vérifier que le token n'est pas expiré
        if (now()->gt($token->expires_at)) {
            abort(403, 'Ce token a expiré et ne peut pas être supprimé.');
        }
        
        $token->delete();

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', 'Lien d\'upload supprimé avec succès.');
    }

    /**
     * Réinitialise un token utilisé (pour permettre une réutilisation).
     */
    public function reset($slug, $tokenId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $token = $album->uploadTokens()->findOrFail($tokenId);

        // Vérifier que le token n'est pas expiré
        if (now()->gt($token->expires_at)) {
            abort(403, 'Ce token a expiré et ne peut pas être réinitialisé.');
        }

        $token->update(['used' => false]);

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', 'Lien d\'upload réinitialisé. Il peut maintenant être réutilisé.');
    }


    /**
     * Génère un nom de fichier unique.
     */
    private function makeUniqueFileName($file, $albumSlug): string
    {
        $extension = $file->getClientOriginalExtension();
        return $albumSlug . '_' .  Str::random(8) . '.' . $extension;
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
}