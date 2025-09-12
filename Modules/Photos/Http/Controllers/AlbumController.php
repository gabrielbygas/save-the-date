<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Illuminate\Http\Request;
use App\Models\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Modules\Photos\Mail\AlbumCreatedMail;
use Illuminate\Support\Facades\Mail;

class AlbumController extends Controller
{
    public function create()
    {
        return view('photos::albums.create');
    }

    public function home()
    {
        $albums = Album::all();
        return view('photos::index', compact('albums'));
    }

    public function index() // liste de tous les albums pour l'admin exclusivement
    {
        $albums = Album::all();
        $client = $albums->first()->client;
        return view('photos::albums.index', compact('albums', 'client'));
    }

    public function show($slug)
    {
        $album = Album::where('slug', $slug)->with('photos')->firstOrFail();
        $photos = $album->photos()->latest()->get();
        // renvoyer aussi le client Mr name ane Mrs name
        $client = $album->client;
        return view('photos::albums.show', compact('album', 'photos', 'client'));
    }

    public function share($token)
    {
        $album = Album::where('share_url_token', $token)->with('photos')->firstOrFail();

        // Vérifie si l'album est actif
        if ($album->status !== 'active') {
            abort(403, 'Cet album n\'est pas activé. Veuillez effectuer le paiement.');
        }

        // Vérifie si la date de stockage est dépassée
        if (now()->gt($album->storage_until_at)) {
            abort(403, 'Le lien de partage a expiré. La période de stockage de cet album est terminée.');
        }

        $photos = $album->photos()->latest()->get();
        $client = $album->client;
        return view('photos::albums.show', compact('album', 'photos', 'client'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'mr_first_name'    => 'required|string|max:100',
            'mr_last_name'     => 'required|string|max:100',
            'mrs_first_name'   => 'required|string|max:100',
            'mrs_last_name'    => 'required|string|max:100',
            'email'            => 'required|email',
            'phone'            => 'nullable|string|max:20',
            'album_title'      => 'required|string|max:255',
            'wedding_date'     => 'required|date',
            'max_guests'       => 'nullable|integer|min:1|max:1000',
            'opens_at'         => 'nullable|date',
            'storage_until_at' => 'nullable|date|after:wedding_date',
            'status'           => 'required|in:draft,active,archived',
        ]);

        // Générer slug unique
        $slug = Str::slug($validated['mr_last_name'] . '-' . $validated['mrs_last_name']);
        $originalSlug = $slug;
        $count = 1;
        while (Album::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Générer un token propriétaire unique
        $ownerToken = bin2hex(random_bytes(16));

        // Calcul automatique des dates si non fournies
        $weddingDate = \Carbon\Carbon::parse($validated['wedding_date']);
        $validated['opens_at'] = $validated['opens_at'] ?? $weddingDate->copy()->subDays(7);
        $validated['storage_until_at'] = $validated['storage_until_at'] ?? $weddingDate->copy()->addYear();

        // Création / récupération client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            $request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'phone'])
        );

        // 2. Vérification pour un album existant
        if (Album::where('client_id', $client->id)->exists()) {
            // Un album existe déjà pour ce client.
            // Retournez une erreur avec un message
            return redirect()->back()->withErrors(['message' => 'Un album a déjà été créé pour ce client.'])->withInput();
        }

        // Générer token + QR
        $shareToken = bin2hex(random_bytes(16));
        $shareUrl = route('albums.share', $shareToken);

        $qrCodeImage = QrCode::format('svg')->size(300)->generate($shareUrl);
        $qrCodePath = 'qrcodes/' . $slug . '_qrcode.svg';
        Storage::disk('public')->put($qrCodePath, $qrCodeImage);

        // Création de l’album
        $album = Album::create([
            'slug'             => $slug,
            'client_id'        => $client->id,
            'owner_token'      => $ownerToken,
            'album_title'      => $validated['album_title'],
            'wedding_date'     => $validated['wedding_date'],
            'max_guests'       => $validated['max_guests'] ?? 300,
            'status'           => $validated['status'],
            'opens_at'         => $validated['opens_at'],
            'storage_until_at' => $validated['storage_until_at'],
            'share_url_token'  => $shareToken,
            'qr_code_path'     => $qrCodePath,
        ]);

        // Envoi de l'email de confirmation
        Mail::to($client->email)->send(new AlbumCreatedMail($album));

        return redirect()->route('albums.index')->with('success', 'Album créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $validated = $request->validate([
            'album_title'  => 'required|string|max:255',
            'max_guests'   => 'nullable|integer|min:1|max:1000',
            'status'       => 'required|in:draft,active,archived',
        ]);

        $album->update($validated);

        return redirect()->route('albums.show', $album->slug)->with('success', 'Album mis à jour.');
    }


    // creer Token d'upload pour les invités
    public function requestUploadToken(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        if ($album->uploadTokens()->count() >= $album->max_guests) {
            return back()->with('error', 'Le nombre maximal d\'invités a été atteint.');
        }

        $token = bin2hex(random_bytes(16)); // Token aléatoire de 16 caractères
        $uploadToken = UploadToken::create([
            'album_id'   => $album->id,
            'token'      => $token,
            'visitor_name' => $request->visitor_name,
            'visitor_email' => $request->visitor_email,
            'visitor_phone' => $request->visitor_phone,
            'expires_at' => now()->addDays(30),
        ]);

        // Envoyer un email à $request->visitor_email avec :
        // - Lien pour upload : route('photos.upload.token', [$album->slug, $token])
        // - Lien pour download : route('photos.download.all', [$album->slug, $token])

        return redirect()->route('albums.share', $album->share_url_token)
            ->with('success', 'Votre lien d\'upload a été généré et envoyé à votre email !');
    }



    public function destroy($slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();

        // Supprimer toutes les photos
        foreach ($album->photos as $photo) {
            if ($photo->original_path && Storage::disk('private')->exists($photo->original_path)) {
                Storage::disk('private')->delete($photo->original_path);
            }
            if ($photo->thumb_path && Storage::disk('private')->exists($photo->thumb_path)) {
                Storage::disk('private')->delete($photo->thumb_path);
            }
            $photo->delete();
        }

        // Supprimer QR code s’il existe
        if ($album->qr_code_path && Storage::disk('public')->exists($album->qr_code_path)) {
            Storage::disk('public')->delete($album->qr_code_path);
        }

        // Supprimer tokens & logs
        $album->uploadTokens()->delete();
        $album->accessLogs()->delete();

        // Supprimer dossier du slug (sécurité)
        Storage::disk('private')->deleteDirectory("albums/{$album->slug}");
        Storage::disk('private')->deleteDirectory("thumbs/{$album->slug}");

        // Enfin supprimer l’album
        $album->delete();

        return redirect()->route('albums.index')->with('success', 'Album supprimé avec succès.');
    }
}