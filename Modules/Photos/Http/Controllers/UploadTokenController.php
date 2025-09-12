<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Illuminate\Support\Str;

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
     * Génère de nouveaux tokens d'upload pour un album.
     */
    public function store(Request $request, $slug)
    {
        $request->validate([
            'count' => 'required|integer|min:1|max:50', // Max 50 tokens à la fois
            'guest_names' => 'nullable|array',
            'guest_names.*' => 'nullable|string|max:100',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();
        $count = $request->count;
        $guestNames = $request->guest_names ?? [];

        $generatedTokens = [];

        for ($i = 0; $i < $count; $i++) {
            $token = bin2hex(random_bytes(16)); // Token aléatoire de 16 caractères
            $guestName = $guestNames[$i] ?? null;

            $uploadToken = UploadToken::create([
                'album_id'   => $album->id,
                'token'      => $token,
                'guest_name' => $guestName,
                'expires_at' => now()->addDays(30), // Expiration dans 30 jours
            ]);

            $generatedTokens[] = [
                'token'      => $token,
                'guest_name' => $guestName,
                'url'        => route('photos.upload.token', [$album->slug, $token]),
            ];
        }

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', "{$count} liens d'upload générés avec succès !")
            ->with('generated_tokens', $generatedTokens);
    }

    /**
     * Supprime un token d'upload.
     */
    public function destroy($slug, $tokenId)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $token = $album->uploadTokens()->findOrFail($tokenId);
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
        $token->update(['used' => false]);

        return redirect()->route('upload_tokens.index', $album->slug)
            ->with('success', 'Lien d\'upload réinitialisé. Il peut maintenant être réutilisé.');
    }
}