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
        $album = Album::where('slug', $request->slug)->firstOrFail();
        if ($request->owner_token !== $album->owner_token) {
            abort(403, 'Accès non autorisé.');
        }
        return $next($request);
    }
}