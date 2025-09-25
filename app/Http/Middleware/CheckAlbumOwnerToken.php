<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Photos\Models\Album;
use Illuminate\Support\Facades\Log;

class CheckAlbumOwnerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug'); // récupère le paramètre de route
        if (!$slug) {
            Log::error("CheckAlbumOwnerToken - Slug manquant dans la route.");
            abort(403, 'Slug manquant dans la route.');
        }

        $album = Album::where('slug', $slug)->first();
        if (!$album) {
            Log::error("CheckAlbumOwnerToken - Album introuvable.");
            abort(404, 'Album introuvable.');
        }

        // Récupérer le owner_token depuis la requête (query ou body)
        $ownerToken = $request->query('owner_token') ?? $request->input('owner_token');

        if (!$ownerToken || $ownerToken !== $album->owner_token) {
            Log::error("CheckAlbumOwnerToken - Accès non autorisé. Token invalide.");
            abort(403, 'Accès non autorisé. Token invalide.');
        }

        return $next($request);
    }
}