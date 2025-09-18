<?php
  
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;

class CheckInviteToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');
        $token = $request->route('token');

        if (!$slug || !$token) {
            abort(403, 'Paramètres manquants.');
        }

        $album = Album::where('slug', $slug)->firstOrFail();

        $uploadToken = UploadToken::where('token', $token)
            ->where('album_id', $album->id)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return $next($request);
    }
}