<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\App\Models\Payment as Payment;
use Modules\Photos\Models\Album;


class PaymentController extends Controller
{
    // Liste tous les paiements
    public function index()
    {
        $payments = Payment::all();
        return view('photos::payments.index', compact('payments'));
    }

    // Affiche un paiement spécifique a un album en utilisant le slug
    public function show($slug)
    {
        $payment = Payment::where('slug', $slug)->firstOrFail();
        return view('photos::payments.show', compact('payment'));
    }

    // Enregistre un nouveau paiement (lié à un album)
    public function store(Request $request, $slug)
    {
        $validated = $request->validate([
            'album_id' => 'required|exists:albums,id',
            'amount'   => 'required|numeric|min:0',
            'status'   => 'required|string|in:pending,paid,failed',
            'provider' => 'required|string',
            'currency' => 'sometimes|string|size:3',
            'provider_ref' => 'sometimes|string|nullable',
            'paid_at' => 'sometimes|date|nullable',
        ]);

        $payment = Payment::create($validated);

        // Exemple : si payé -> activer l’album
        if ($payment->status === 'paid') {
            $album = Album::find($validated['album_id']);
            $album->is_active = true;
            $album->save();
        }

        return redirect()->route('photos.payments.index')
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