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
use Illuminate\Support\Facades\Mail;
use Modules\Photos\Mail\AlbumUploadToken;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;
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
        return view('photos::upload_tokens.invite', compact('album', 'tokens'));
    }

    /**
     * Ajouter les photos via un token d'invité (formulaire).
     */
    public function createInvitePhotos($slug, $token)
    {
        try {
            DB::beginTransaction();

            $album = Album::where('slug', $slug)->firstOrFail();

            $uploadToken = $album->uploadTokens()
                ->where('token', $token)
                ->where('expires_at', '>', now())
                ->lockForUpdate() // Verrouille la ligne pour éviter les conflits
                ->firstOrFail();

            DB::commit();

            return view('photos::upload_tokens.create', compact('uploadToken', 'album'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("UploadTokenController - Erreur lors de l'accès au token : " . $e->getMessage());
            abort(403, 'Lien d\'upload introuvable ou expiré.');
        }
    }

    // creer Token d'upload pour les invités
    public function store(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        // Vérifier que le nombre maximal d'invités n'est pas atteint
        if ($album->uploadTokens()->count() >= $album->max_guests) {
            return back()->with('error', 'Le nombre maximal d\'invités a été atteint.');
        }

        $validated = $request->validate([
            'visitor_name'  => 'required|string|max:100',
            'visitor_email' => 'required|email',
            'visitor_phone' => 'required|string|max:20',
        ]);

        $token = bin2hex(random_bytes(16)); // Token aléatoire de 16 caractères

        // Vérifier si l'invité a déjà un token non expiré pour cet album
        $existingToken = UploadToken::where('visitor_email', $validated['visitor_email'])
            ->where('album_id', $album->id)
            ->where('expires_at', '>', now())
            ->first();
        if ($existingToken) {
            return back()->with('error', 'Vous avez déjà un lien d\'upload actif pour cet album.');
        }

        $uploadToken = UploadToken::create([
            'album_id'      => $album->id,
            'token'         => $token,
            'visitor_name'  => $validated['visitor_name'],
            'visitor_email' => $validated['visitor_email'],
            'visitor_phone' => $validated['visitor_phone'],
            'used'          => false,
            'expires_at'    => \Carbon\Carbon::parse($album->wedding_date)->addDays(7),
        ]);

        // Envoyer un email à $validated['visitor_email'] avec :
        try {
            Mail::to($validated['visitor_email'])->send(new AlbumUploadToken($album, $uploadToken));
        } catch (\Exception $e) {
            Log::warning('Email non envoyé : ' . $e->getMessage());
        }
        // - Lien pour download : route('photos.download.all', [$album->slug, $token])

        return redirect()->route('albums.share', $album->share_url_token)
            ->with('success', 'Votre lien d\'upload a été généré et envoyé à votre email !');
    }

    /**
     * Stocke une photo via un token d'invité.
     */
    public function storeInvitePhotos(Request $request, $slug, $token)
    {
        $request->validate([
            'photos'      => 'required|array',
            'photos.*'    => 'image|max:10240',
            'category'    => 'nullable|in:civil,religieux,coutumier,reception,autre',
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();

        // Vérifier que le token d'upload est valide
        $uploadToken = $album->uploadTokens()
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $directory = "albums/{$album->slug}";

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        // Vérifier que l'email de l'invité correspond
        if ($request->has('visitor_email') && $uploadToken->visitor_email !== $request->visitor_email) {
            Log::error("UploadTokenController - Erreur - Email de l'invité invalide : " . $request->visitor_email);
            abort(403, 'Ce lien d\'upload ne vous est pas destiné.');
        }

        // Vérifier si l'invité a déjà uploadé 5 photos
        if ($uploadToken->used || $uploadToken->photo_count >= 5) {
            Log::warning("CheckInviteToken - Votre Token a déjà été utilisé ou vous avez déjà publié plus de 5 photos", [
                'token_id' => $uploadToken->id,
                'photo_count' => $uploadToken->photo_count,
                'used' => $uploadToken->used,
            ]);
            return back()->with('error', 'Vous avez déjà uploadé le nombre maximal de 5 photos autorisées.');
        }

        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('private')->exists($directory)) {
            Storage::disk('private')->makeDirectory($directory);
        }

        $successCount = 0;

        foreach ($request->file('photos') as $file) {
            DB::beginTransaction();
            try {
                $fileName = $this->makeUniqueFileName($file, $album->slug); // Génère un nom de fichier unique
                $path = $file->storeAs($directory, $fileName, 'private');   // Chemin relatif

                if (!Storage::disk('private')->exists($path)) { // Vérification du stockage
                    throw new \Exception("Le fichier n'a pas été stocké.");
                }

                $thumbPath = $this->createThumbnail($path, $album->slug); // Crée la miniature

                $photoData = [
                    'album_id'        => $album->id,
                    'upload_token_id' => $uploadToken->id, // ✅ lien direct avec le visiteur
                    'original_path'   => $directory . '/' . $fileName,
                    'file_name'       => $fileName,
                    'thumb_path'      => $thumbPath,
                    'size_bytes'      => $file->getSize(),
                    'mime'            => $file->getMimeType(),
                    'category'        => $request->category ?? 'autre',
                    'exif_json'       => $request->exif_json,
                ];

                $photo = Photo::create($photoData);
                Log::info("Photo créée avec ID : " . $photo->id);

                // Log l'accès
                AlbumAccessLog::create([
                    'album_id'   => $album->id,
                    'photo_id'   => $photo->id,
                    'visitor_ip' => $request->ip(),
                    'action'     => 'upload',
                    'user_agent' => $request->userAgent(),
                ]);

                // Incrémenter le compteur de photos pour ce token
                $uploadToken->increment('photo_count');

                DB::commit();
                $successCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur upload invité : " . $e->getMessage());
                return back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
            }
        }

        if ($successCount > 0) { // Au moins une photo a été uploadée avec succès
            if ($uploadToken->photo_count >= 5) {
                // Marquer le token comme utilisé
                $uploadToken->update(['used' => true]);
            }
            return redirect()->route('photos.invite.serve', [$album->slug, $uploadToken->token])
                ->with('success', "{$successCount} photo(s) ajoutée(s) avec succès.");
        } else { // Aucune photo n'a pu être uploadée
            return back()->with('error', 'Aucune photo n\'a pu être ajoutée. Vérifiez les fichiers et réessayez.');
        }
    }

    /**
     * affiche toutes les photos.
     */
    public function serveInvitePhotos(Request $request, $slug, $token)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $client = $album->client;

        // Vérifier que le token d'upload est valide
        $uploadToken = $album->uploadTokens()
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        // Récupérer l'ID du visiteur courant (via son token)
        $visitorTokenId = $uploadToken->id;

        // Filtre par catégorie si spécifié
        $category = $request->get('category');

        $query = $album->photos()
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->orderByRaw("CASE WHEN upload_token_id = ? THEN 0 ELSE 1 END", [$visitorTokenId]) // ses photos d'abord
            ->orderBy('created_at', 'desc'); // puis tri décroissant par date

        $photos = $query->get();
        // $photos = $query->paginate(20); // si tu veux la pagination

        // Récupérer toutes les catégories présentes dans l’album
        $categories = $album->photos()
            ->select('category')
            ->groupBy('category')
            ->pluck('category');

        return view('photos::upload_tokens.invite', compact(
            'photos',
            'album',
            'client',
            'uploadToken',
            'categories',
            'category'
        ));
    }

    /**
     * Affiche une photo spécifique via un token d'invité.
     */
    public function showInvitePhotos($slug, $id, $token)
    {
        // Récupérer l'album et vérifier le token
        $album = Album::where('slug', $slug)->firstOrFail();

        // Vérifier que le token est valide
        $uploadToken = $album->uploadTokens()
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        // Récupérer la photo
        $photo = $album->photos()->findOrFail($id);

        // Vérifier que la photo appartient bien à l'album
        if ($photo->album_id != $album->id) {
            abort(404, 'Photo introuvable.');
        }

        // Log l'accès à la photo
        AlbumAccessLog::create([
            'album_id'   => $album->id,
            'photo_id'   => $photo->id,
            'visitor_ip' => request()->ip(),
            'action'     => 'view',
            'user_agent' => request()->userAgent(),
        ]);

        // Afficher la photo dans une vue dédiée
        return view('photos::upload_tokens.show', compact('photo', 'album', 'uploadToken'));
    }



    /**
     * Supprime un token d'upload.
     */
    public function destroy($slug, $tokenId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $uploadToken = $album->uploadTokens()->findOrFail($tokenId);

        // Vérifier que le token n'est pas expiré
        if (now()->gt($uploadToken->expires_at)) {
            Log::error("UploadTokenController - Ce token a expiré et ne peut pas être supprimé. : " . $uploadToken->token);
            abort(403, 'Ce token a expiré et ne peut pas être supprimé.');
        }

        $uploadToken->delete();

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', 'Lien d\'upload supprimé avec succès.');
    }

    /**
     * Réinitialise un token utilisé (pour permettre une réutilisation).
     */
    public function reset($slug, $tokenId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $uploadToken = $album->uploadTokens()->findOrFail($tokenId);

        // Vérifier que le token n'est pas expiré
        if (now()->gt($uploadToken->expires_at)) {
            Log::error("UploadTokenController - Ce token a expiré et ne peut pas être réinitialié : " . $uploadToken->token);
            abort(403, 'Ce token a expiré et ne peut pas être réinitialisé.');
        }

        $uploadToken->update([
            'used' => false,
            'photo_count' => 0, // Réinitialiser le compteur de photos
        ]);

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', 'Lien d\'upload réinitialisé. Il peut maintenant être réutilisé.');
    }


    /**
     * Génère un nom de fichier unique.
     */
    private function makeUniqueFileName($file, $albumSlug): string
    {
        $extension = $file->getClientOriginalExtension();
        return $albumSlug . '_' . Str::random(8) . '.' . $extension;
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
     * Check AlbumStorage date and payment status
     */
    private function checkActiveAlbumStorage(Album $album)
    {
        if (now()->gt($album->storage_until_at)) {
            Log::error("UploadTokenController - La période de stockage de cet album est terminée. ");
            abort(403, 'La période de stockage de cet album est terminée.');
        }
        // Vérifie si l'album est actif
        // if ($album->status !== 'active') {
        //Log::error("UploadTokenController - Cet album n\'est pas activé. Veuillez effectuer le paiement.");
        //abort(403, 'Cet album n\'est pas activé. Veuillez effectuer le paiement.');
        //}
    }
}