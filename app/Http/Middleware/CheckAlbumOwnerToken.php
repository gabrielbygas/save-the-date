<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Photos\Models\Album;

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
            abort(403, 'Slug manquant dans la route.');
        }

        $album = Album::where('slug', $slug)->first();
        if (!$album) {
            abort(404, 'Album introuvable.');
        }

        // Récupérer le owner_token depuis la requête (query ou body)
        $ownerToken = $request->query('owner_token') ?? $request->input('owner_token');

        if (!$ownerToken || $ownerToken !== $album->owner_token) {
            abort(403, 'Accès non autorisé. Token invalide.');
        }

        return $next($request);
    }
}