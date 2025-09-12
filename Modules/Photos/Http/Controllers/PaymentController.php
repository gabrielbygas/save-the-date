<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\Models\Payment as Payment;
use Modules\Photos\Models\Album;


class PaymentController extends Controller
{
    // Liste tous les paiements
    public function index()
    {
        $payments = Payment::all();
        // $payments = Payment::paginate(20);
        return view('photos::payments.index', compact('payments'));
    }

    // Affiche un paiement spécifique a un album en utilisant le slug
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('photos::payments.show', compact('payment'));
    }

    // Enregistre un nouveau paiement (lié à un album)
    public function store(Request $request, $slug)
    {
        $album = Album::where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'amount'   => 'required|numeric|min:0',
            'status'   => 'required|string|in:pending,paid,failed',
            'provider' => 'required|string',
            'currency' => 'required|string|size:3', // Obligatoire
            'provider_ref' => 'sometimes|string|nullable',
            'paid_at' => 'sometimes|date|nullable',
        ]);
        // Vérifier la cohérence entre album_id et slug
        if ($validated['album_id'] != $album->id) {
            abort(403, 'L\'album spécifié ne correspond pas au slug.');
        }
        // Vérifier les doublons de paiements "paid"
        if ($validated['status'] === 'paid' && Payment::where('album_id', $validated['album_id'])->where('status', 'paid')->exists()) {
            return back()->with('error', 'Un paiement valide existe déjà pour cet album.');
        }
        $payment = Payment::create($validated);

        // Activer l'album si le paiement est "paid"
        if ($payment->status === 'paid' && $album->status !== 'active') {
            $album->status = 'active';
            $album->save();
        }

        return redirect()->route('albums.show', $album->slug)
            ->with('success', 'Paiement enregistré avec succès.');
    }


    // Mise à jour d’un paiement
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|in:pending,paid,failed',
        ]);

        $payment->update($validated);

        return redirect()->route('photos.payments.index')
            ->with('success', 'Paiement mis à jour.');
    }

    // Supprime un paiement
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('photos.payments.index')
            ->with('success', 'Paiement supprimé.');
    }
}