<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Illuminate\Support\Facades\Log;

class CheckInviteToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');
        $token = $request->route('token');

        if (!$slug || !$token) {
            Log::error("Paramètres manquants : slug={$slug}, token={$token}");
            abort(403, 'Paramètres manquants.');
        }

        try {
            $album = Album::where('slug', $slug)->firstOrFail();
            
            $uploadToken = UploadToken::where('token', $token)
                ->where('album_id', $album->id)
                ->first();

            if (!$uploadToken) {
                Log::error("Token introuvable", [
                    'slug' => $slug,
                    'token' => $token,
                    'album_id' => $album->id,
                ]);
                abort(403, 'Lien d\'upload introuvable: Token introuvable.');
            }

            // Vérifier si le token est utilisé ou si photo_count >= 5
            if ($uploadToken->used || $uploadToken->photo_count >= 5) {
                Log::warning("Votre Token a déjà été utilisé ou vous avez déjà publié plus de 5 photos", [
                    'token_id' => $uploadToken->id,
                    'photo_count' => $uploadToken->photo_count,
                    'used' => $uploadToken->used,
                ]);
                abort(403, 'Votre Token a déjà été utilisé ou vous avez déjà publié plus de 5 photos');
            }

            if ($uploadToken->expires_at < now()) {
                Log::error("Token expiré", ['token_id' => $uploadToken->id, 'expires_at' => $uploadToken->expires_at]);
                abort(403, 'Lien d\'upload expiré.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error("Erreur dans CheckInviteToken : " . $e->getMessage());
            abort(403, 'Lien d\'upload introuvable.');
        }
    }
}