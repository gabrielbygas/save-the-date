<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Photos\Models\Album as Album;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
// use App\Mail\OrderConfirmation;

class AlbumController extends Controller
{   
    public function create()
    {
        return view('photos::albums.create');
    }

    public function index()
    {
        $albums = Album::all();
        return view('photos::albums.index', compact('albums'));
    }

    public function show($slug) //affiche les photos d un album
    {
        $album = Album::where('slug', $slug)->with('photos')->firstOrFail();
        return view('photos::albums.show', compact('album'));
    }

    public function share($token)
    {
        $album = Album::where('share_url_token', $token)->with('photos')->firstOrFail();
        return view('photos::albums.show', compact('album'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'mr_first_name'        => 'required|string|max:100',
            'mr_last_name'         => 'required|string|max:100',
            'mrs_first_name'       => 'required|string|max:100',
            'mrs_last_name'        => 'required|string|max:100',
            'email'                => 'required|email',
            'phone'                => 'nullable|string|max:20',
            'album_title'          => 'required|string|max:255',
            'wedding_date'         => 'required|date',
            'max_guests'           => 'nullable|integer|min:1|max:1000',
            'opens_at'             => 'nullable|date',
            'storage_until_at'     => 'nullable|date|after:wedding_date',
            'status'               => 'required|in:draft,active,archived',
        ]);

        // Generer le slug unique
        $request['slug'] = Str::slug($request['mr_last_name'] . '-' . $request['mrs_last_name']);
        $originalSlug = $request['slug'];
        $count = 1;
        while (Album::where('slug', $request['slug'])->exists()) { // tant que le slug existe deja
            $request['slug'] = $originalSlug . '-' . $count++;
        }

        //calculer  dates automatiques
        if ($request->wedding_date) {
            $weddingDate = \Carbon\Carbon::parse($request->wedding_date);
            $request['opens_at'] = $weddingDate->copy()->subDays(7);   // calculer opens_at (7 jours avant la date du mariage)
            $request['storage_until_at'] = $weddingDate->copy()->addYear();  // calculer storage_until_at (1 an apres la date du mariage)
        }

        // Créer le client en evitant le doublon
        $client = Client::firstOrCreate(
            ['email' => $request->email],
            $request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'phone'])
        );
        $request['client_id'] = $client->id;

        // Generer un token unique pour le partage
        $shareToken = bin2hex(random_bytes(16));
        $request['share_url_token'] = $shareToken;

        // Generer le QR code
        $shareUrl = route('albums.share', $shareToken);
        $qrCodeImage = QrCode::format('svg')->size(300)->generate($shareUrl); //png avec php-imagick extension
        $qrCodePath = 'qrcodes/' . $request['slug'] . '_qrcode.svg';
        Storage::disk('public')->put($qrCodePath, $qrCodeImage);
        $request['qr_code_path'] = $qrCodePath;

        // Création de l'album
        $album = Album::create([
            'slug'               => $request['slug'],
            'client_id'          => $client->id,
            'album_title'        => $request['album_title'],
            'wedding_date'       => $request['wedding_date'],
            'max_guests'         => $request['max_guests'] ?? 300,
            'status'             => $request['status'],
            'opens_at'          => $request['opens_at'],
            'storage_until_at'   => $request['storage_until_at'],
            'share_url_token'    => $request['share_url_token'],
            'qr_code_path'       => $request['qr_code_path'],
        ]);

        // Envoi d'un email de confirmation (optionnel)
        // Mail::to($client->email)->send(new OrderConfirmation($album));
        
        return redirect()->route('albums.index')->with('success', 'Album créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->all());
        return redirect()->route('albums.show', $album->id)->with('success', 'Album mis à jour.');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album supprimé.');
    }
}