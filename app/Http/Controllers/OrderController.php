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
            'mr_first_name'        => 'required|string|max:100',
            'mr_last_name'         => 'required|string|max:100',
            'mrs_first_name'       => 'required|string|max:100',
            'mrs_last_name'        => 'required|string|max:100',
            'email'                => 'required|email',
            'phone'                => 'nullable|string|max:20',
            'wedding_date'         => 'required|date',
            'wedding_location'     => 'required|string|max:255',
            'pack_id'              => 'required|exists:packs,id',
            'theme_id'             => 'nullable|exists:themes,id',
            'terms'                => 'accepted',
            'photos'               => 'nullable|array|max:5',
            'photos.*'             => 'file|mimes:jpeg,png,jpg,mp4,mov,ogg|max:10240',
        ]);
        
        $request['wedding_title'] = 'Mariage de ' . $request->mr_first_name . ' et ' . $request->mrs_first_name;

        // Génération d'un numéro de commande unique
        $request['confirmation_number'] = 'ORDER-' . strtoupper(uniqid());

        // date limite de paiement
        $request['payment_due_at'] = Carbon::now()->addWeekdays(3); // 3 jours après la commande, ignorant les dimanches

        // 1. Créer le client
        $client = Client::create($request->only(['mr_first_name', 'mr_last_name', 'mrs_first_name', 'mrs_last_name', 'email', 'phone']));

        // 2. Créer la commande
        $order = $client->orders()->create([
            'pack_id'          => $request->pack_id,
            'theme_id'         => $request->theme_id,
            'confirmation_number'     => $request->confirmation_number,
            'wedding_title'    => $request->wedding_title,
            'wedding_date'     => $request->wedding_date,
            'wedding_location' => $request->wedding_location,
            'payment_due_at'   => $request->payment_due_at,
        ]);

        //sauvergader dans Log
        Log::info('Nouvelle commande créée', [
            'confirmation_number' => $order->confirmation_number,
            'client_id' => $client->id,
            'pack_id' => $request->pack_id,
            'theme_id' => $request->theme_id,
            'wedding_title' => $request->wedding_title,
            'wedding_date' => $request->wedding_date,
            'wedding_location' => $request->wedding_location,
        ]);

        // 3. Upload fichiers
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('uploads/media', 'public');

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


        return redirect()->route('order.create')->with('success', 'Votre commande a été enregistrée !');
    }
}