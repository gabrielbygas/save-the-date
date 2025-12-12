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
        $slug = $request->route('slug');
        if (!$slug) {
            Log::error("CheckAlbumOwnerToken - Slug manquant dans la route.");
            abort(403, 'Slug manquant dans la route.');
        }

        $album = Album::where('slug', $slug)->firstOrFail();

        // Check if authenticated via session (owner)
        if ($request->session()->has('client_id')) {
            $clientId = $request->session()->get('client_id');
            if ($album->client_id === $clientId) {
                return $next($request); // modified by COPILOT
            }
        }

        // Check if authenticated via owner_token
        $ownerToken = $request->query('owner_token') ?? $request->input('owner_token');
        if ($ownerToken && hash_equals($album->owner_token, $ownerToken)) {
            return $next($request); // modified by COPILOT
        }

        Log::error("CheckAlbumOwnerToken - Accès non autorisé", ['slug' => $slug, 'client_id' => $request->session()->get('client_id')]);
        abort(403, 'Accès non autorisé.');
    }
}