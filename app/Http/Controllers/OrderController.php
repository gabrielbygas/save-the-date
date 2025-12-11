<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Theme;
use App\Models\Order;
use App\Models\Client;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function create()
    {
        $packs = Pack::all();
        $themes = Theme::all();
        return view('order.create', compact('packs', 'themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // modify by claude - improved validation
            'mr_first_name'        => 'required|string|max:100',
            'mr_last_name'         => 'required|string|max:100',
            'mrs_first_name'       => 'required|string|max:100',
            'mrs_last_name'        => 'required|string|max:100',
            'email'                => 'required|string|email:rfc,dns|max:255', // Claude: stricter email validation
            'phone'                => ['nullable', 'string', 'regex:/^[\+]?[0-9\s\-\(\)]{8,20}$/'], // Claude: phone format validation
            'wedding_date'         => 'required|date|after:today|before:+2 years', // Claude: prevent far future dates
            'wedding_location'     => 'required|string|max:255',
            'pack_id'              => 'required|exists:packs,id',
            'theme_id'             => 'nullable|exists:themes,id',
            'terms'                => 'accepted',
            // modify by claude - improved file validation
            'photos'               => 'nullable|array|max:5',
            'photos.*'             => [
                'file',
                'mimes:jpeg,png,jpg,mp4,mov,ogg',
                'max:51200', // 50 MB max (videos can be larger)
                function ($attribute, $value, $fail) {
                    // Validation basée sur le type MIME réel
                    $mimeType = $value->getClientMimeType();

                    // Pour les images: validation stricte
                    if (str_starts_with($mimeType, 'image/')) {
                        // Vérifier que c'est une vraie image
                        $imageInfo = @getimagesize($value->getPathname());
                        if ($imageInfo === false) {
                            $fail('Le fichier n\'est pas une image valide.');
                        }
                        // Limite de taille pour images: 5 MB
                        if ($value->getSize() > 5242880) {
                            $fail('Les images ne doivent pas dépasser 5 MB.');
                        }
                    }

                    // Pour les vidéos: vérifier que c'est bien une vidéo
                    if (str_starts_with($mimeType, 'video/')) {
                        $allowedVideoMimes = ['video/mp4', 'video/quicktime', 'video/ogg'];
                        if (!in_array($mimeType, $allowedVideoMimes)) {
                            $fail('Type de vidéo non autorisé.');
                        }
                    }
                },
            ],
        ]);

        $request['wedding_title'] = 'Mariage de ' . strtoupper($request->mr_first_name) . ' et ' . strtoupper($request->mrs_first_name);

        // 1. Génération d'un numéro de commande unique
        $request['confirmation_number'] = 'ORDER-' . strtoupper(uniqid());

        // 2. date limite de paiement
        $request['payment_due_at'] = Carbon::now()->addWeekdays(3); // 3 jours après la commande, ignorant les dimanches

        // 3. Créer le client en evitant le doublon
        try {
            $client = Client::firstOrCreate(
                ['email' => $request->email],
                $request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'phone'])
            );
        } catch (\Exception $e) {
            // Log ou retour d'erreur personnalisé
            return response()->json(['error' => 'Impossible de créer le client : ' . $e->getMessage()], 500);
        }


        // 4. Créer la commande
        $order = $client->orders()->create([
            'pack_id'          => $request->pack_id,
            'theme_id'         => $request->theme_id,
            'confirmation_number'     => $request->confirmation_number,
            'wedding_title'    => $request->wedding_title,
            'wedding_date'     => $request->wedding_date,
            'wedding_location' => $request->wedding_location,
            'payment_due_at'   => $request->payment_due_at,
        ]);

        // 5. Sauvegarder dans Log
        Log::info('Nouvelle commande créée', [
            'confirmation_number' => $order->confirmation_number,
            'client_id' => $client->id,
            'pack_id' => $request->pack_id,
            'theme_id' => $request->theme_id,
            'wedding_title' => $request->wedding_title,
            'wedding_date' => $request->wedding_date,
            'wedding_location' => $request->wedding_location,
        ]);

        // modify by claude
        // 6. Upload fichiers
        // Claude: Security - Store media on private disk instead of public to control access
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Construire dynamiquement le chemin de stockage
                $folder = 'uploads/media/' . $request['confirmation_number'];
                $path = $file->store($folder, 'private'); // Changed from 'public' to 'private'

                // Déterminer le type de média
                $type = 'photo'; // Par défaut, on suppose que c'est une photo
                $mimeType = $file->getClientMimeType();
                if (str_starts_with($mimeType, 'video/')) {
                    $type = 'video';
                }

                $order->media()->create([
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        // 7. Envoi de l'email de confirmation
        // en attente de configurer le mail pour admin 
        Mail::to($client->email)
            ->bcc(['dev@gabrielkalala.com', 'web@gabrielkalala.com'])
            ->send(new OrderConfirmation($order));


        return redirect()->route('order.create')->with('success', 'Votre commande a été enregistrée !');
    }
}