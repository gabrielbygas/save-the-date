<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Modules\Photos\Models\Otp;
use Illuminate\Http\Request;
use App\Models\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Modules\Photos\Mail\AlbumCreatedMail;
use Modules\Photos\Mail\SendOTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Modules\Photos\Mail\AlbumUploadToken;
use Carbon\Carbon;


class AlbumController extends Controller
{
    public function create()
    {
        return view('photos::albums.create');
    }

    public function home()
    {
        $albums = Album::with('client', 'photos')->get(); // modified by COPILOT - eager load
        return view('photos::index', compact('albums'));
    }

    public function index() // liste de tous les albums
    {
        // $albums = Album::all();
        // $client = $albums->first()->client;
        // return view('photos::albums.index', compact('albums', 'client'));

        return view('photos::albums.login');
    }

    public function show($slug, Request $request)
    {
        // Vérifie que le client est connecté (via session)
        if (!$request->session()->has('client_id')) {
            return redirect()->route('albums.login')->with('error', 'Veuillez vous authentifier.');
        }

        $clientId = $request->session()->get('client_id');
        $album = Album::where('slug', $slug)->where('client_id', $clientId)->with(['client', 'photos' => fn($q) => $q->latest()])->firstOrFail(); // modified by COPILOT - eager load both
        $photos = $album->photos;
        $client = $album->client;

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        return view('photos::albums.show', compact('album', 'photos', 'client'));
    }

    public function share($token)
    {
        $album = Album::where('share_url_token', $token)->with(['client', 'photos' => fn($q) => $q->latest()])->firstOrFail(); // modified by COPILOT - eager load both

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        $photos = $album->photos;
        $client = $album->client;
        return view('photos::albums.share', compact('album', 'photos', 'client'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'mr_first_name'    => 'required|string|max:100',
            'mr_last_name'     => 'required|string|max:100',
            'mrs_first_name'   => 'required|string|max:100',
            'mrs_last_name'    => 'required|string|max:100',
            'email'            => 'required|string|email:rfc,dns|max:255|unique:clients,email', // modified by COPILOT
            'phone'            => ['nullable', 'string', 'regex:/^[\+]?[0-9\s\-\(\)]{8,20}$/'], // modified by COPILOT
            'album_title'      => 'required|string|max:255',
            'wedding_date'     => 'required|date|after:today|before:+2 years', // modified by COPILOT
            'max_guests'       => 'nullable|integer|min:1|max:1000',
            'opens_at'         => 'nullable|date|before:wedding_date', // modified by COPILOT
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
        $validated['storage_until_at'] = Carbon::now()->addWeekdays(3); // 3 jours pour payer
        //$validated['opens_at'] = $validated['opens_at'] ?? $weddingDate->copy()->subDays(7);
        //$validated['storage_until_at'] = $validated['storage_until_at'] ?? $weddingDate->copy()->addYear();

        // Générer token 
        $ownerToken = bin2hex(random_bytes(16));
        $shareToken = bin2hex(random_bytes(16));
        $shareUrl = route('albums.share', $shareToken);

        DB::beginTransaction();
        try {
            // Création / récupération client
            $client = Client::firstOrCreate(
                ['email' => $validated['email']],
                $request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'phone'])
            );

            // 2. Vérification pour un album existant
            if (Album::where('client_id', $client->id)->exists()) {
                return redirect()->back()->withErrors(['message' => 'Un album a déjà été créé pour ce client.'])->withInput();
            }

            // Générer QR code et le stocker
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

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Supprimer le QR code si généré
            if (Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }
            Log::error('Erreur lors de la création de l\'album : ' . $e->getMessage());
            return redirect()->back()->withErrors(['message' => 'Une erreur est survenue lors de la création de l\'album.'])->withInput();
        }

        // Envoi de l'email
        try {
            Mail::to($client->email)->send(new AlbumCreatedMail($album));
        } catch (\Exception $e) {
            Log::warning('Email non envoyé : ' . $e->getMessage());
        }

        return redirect()->route('albums.show', $album->slug)->with('success', 'Album créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        // checkActiveAlbumStorage
        $this->checkActiveAlbumStorage($album);

        $validated = $request->validate([
            'album_title'  => 'required|string|max:255',
            'max_guests'   => 'nullable|integer|min:1|max:1000',
            'status'       => 'required|in:draft,active,archived',
        ]);

        $album->update($validated);

        return redirect()->route('albums.show', $album->slug)->with('success', 'Album mis à jour.');
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

    /**
     * Génère et envoie un OTP.
     */
    public function sendOTP(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string', // Email ou téléphone
        ]);

        $identifier = $request->identifier;
        $client = Client::where('email', $identifier)->first();

        // Vérification pour un album existant
        if (!$client) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun album trouvé pour ce client.'
                ]);
            }
            return redirect()->back()->withErrors(['message' => 'Aucun album trouvé pour ce client.'])->withInput();
        }

        // Vérifier si l'identifiant a un album actif // modified by COPILOT - security check
        $hasActiveAlbum = Album::where('client_id', $client->id)->where('status', 'active')->exists();
        if (!$hasActiveAlbum) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucun album actif trouvé pour ce client.'
                ]);
            }
            return redirect()->back()->withErrors(['message' => 'Aucun album actif trouvé pour ce client.'])->withInput();
        }

        // Supprime les anciens OTPs pour cet identifiant
        OTP::where('identifier', $identifier)->delete();

        // Crée un nouvel OTP
        $otp = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT); // modified by COPILOT - 8 numeric digits
        $OTP = OTP::create([
            'identifier' => $identifier,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10), // Expire dans 10 minutes
        ]);

        // Envoi de l'email
        try {
            Mail::to($client->email)->send(new SendOTPMail($OTP));
        } catch (\Exception $e) {
            Log::warning('Email non envoyé : ' . $e->getMessage());
        }

        return response()->json([ // modified by COPILOT
            'success' => true,
            'message' => 'Un code OTP a été envoyé à ' . $identifier,
        ]); // modified by COPILOT
    }

    /**
     * Vérifie l'OTP et redirige vers la liste des albums.
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'otp' => 'required|string|size:8',
        ]);

        $otpRecord = OTP::where('identifier', $request->identifier)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        // if (!$otpRecord) {
        //     return back()->with('error', 'Code OTP invalide ou expiré.');
        // }

        if (!$otpRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Code OTP invalide ou expiré.'
            ]);
        }

        // Trouver le client associé à l'identifiant (email ou téléphone)
        $client = Client::where('email', $request->identifier)->first();

        // Stocker l'ID du client en session
        $request->session()->put('client_id', $client->id);

        // Supprime l'OTP utilisé
        $otpRecord->delete();

        // Retourner JSON pour AJAX // modified by COPILOT
        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie !',
            'redirect' => route('albums.list')
        ]); // modified by COPILOT
    }

    /**
     * Affiche la liste des albums du client connecté.
     */
    public function list(Request $request)
    {
        // Vérifie que le client est connecté (via session)
        if (!$request->session()->has('client_id')) {
            return redirect()->route('albums.login')->with('error', 'Veuillez vous authentifier.');
        }

        $clientId = $request->session()->get('client_id');
        $client = Client::findOrFail($clientId);

        // Récupère uniquement les albums du client avec eager loading // modified by COPILOT
        $albums = Album::where('client_id', $clientId)->with(['photos' => fn($q) => $q->select('id', 'album_id', 'thumb_path')->latest()])->get();

        return view('photos::albums.index', compact('albums', 'client'));
    }

    /**
     * Déconnecte le client.
     */
    public function logout(Request $request)
    {
        $request->session()->forget('client_id');
        return redirect()->route('albums.login')->with('success', 'Vous êtes déconnecté.');
    }



    /**
     * Check AlbumStorage date and payment status
     */
    private function checkActiveAlbumStorage(Album $album)
    {
        if (now()->gt($album->storage_until_at)) {
            Log::error("AlbumController - La période de stockage de cet album est terminée. ");
            abort(403, 'La période de stockage de cet album est terminée.');
        }
        // Vérifie si l'album est actif
        // if ($album->status !== 'active') {
        // Log::error("AlbumController - Cet album n\'est pas activé. Veuillez effectuer le paiement.");
        //abort(403, 'Cet album n\'est pas activé. Veuillez effectuer le paiement.');
        //}
    }
}