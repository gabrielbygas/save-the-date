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
            Log::error("CheckInviteToken - Paramètres manquants : slug={$slug}, token={$token}");
            abort(403, 'Paramètres manquants.');
        }

        try {
            $album = Album::where('slug', $slug)->firstOrFail();
            
            $uploadToken = UploadToken::where('token', $token)
                ->where('album_id', $album->id)
                ->first();

            if (!$uploadToken) {
                Log::error("CheckInviteToken - Token introuvable", [
                    'slug' => $slug,
                    'token' => $token,
                    'album_id' => $album->id,
                ]);
                abort(403, 'Lien d\'upload introuvable: Token introuvable.');
            }

            if ($uploadToken->expires_at < now()) {
                Log::error("CheckInviteToken - Token expiré", ['token_id' => $uploadToken->id, 'expires_at' => $uploadToken->expires_at]);
                abort(403, 'Lien d\'upload expiré.');
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error("Erreur dans CheckInviteToken : " . $e->getMessage());
            abort(403, 'Lien d\'upload introuvable.');
        }
    }
}