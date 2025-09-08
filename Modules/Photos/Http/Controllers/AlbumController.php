<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Photos\Models\Album;
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

    public function index()
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
        $photos = $album->photos()->latest()->get();
        return view('photos::albums.show', compact('album', 'photos'));
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

        // Calcul automatique des dates si non fournies
        $weddingDate = \Carbon\Carbon::parse($validated['wedding_date']);
        $validated['opens_at'] = $validated['opens_at'] ?? $weddingDate->copy()->subDays(7);
        $validated['storage_until_at'] = $validated['storage_until_at'] ?? $weddingDate->copy()->addYear();

        // Création / récupération client
        $client = Client::firstOrCreate(
            ['email' => $validated['email']],
            $request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'phone'])
        );

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

    public function destroy($id)
    {
        $album = Album::with('photos')->findOrFail($id);

        // 1. Supprimer le QR code si existe
        if ($album->qr_code_path && Storage::disk('public')->exists($album->qr_code_path)) {
            Storage::disk('public')->delete($album->qr_code_path);
        }

        // 2. Supprimer toutes les photos associées
        foreach ($album->photos as $photo) {
            if ($photo->path && Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
            $photo->delete();
        }

        // 3. Supprimer l’album
        $album->delete();

        return redirect()->route('albums.index')->with('success', 'Album et ses photos supprimés avec succès.');
    }
}