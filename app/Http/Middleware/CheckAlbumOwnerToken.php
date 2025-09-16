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
            return response()->json(['error' => 'Slug manquant dans la route.'], 400);
        }

        $album = Album::where('slug', $slug)->first();
        if (!$album) {
            return response()->json(['error' => 'Album introuvable.'], 404);
        }

        if ($request->owner_token !== $album->owner_token) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        return $next($request);
    }
}