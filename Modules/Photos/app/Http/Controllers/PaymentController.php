<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\App\Models\Payment as Payment;


class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('photos.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('photos.payments.show', compact('payment'));
    }

    public function store(Request $request)
    {
        $payment = Payment::create($request->all());
        return redirect()->route('payments.index')->with('success', 'Paiement enregistré.');
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return redirect()->route('payments.show', $payment->id)->with('success', 'Paiement mis à jour.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Paiement supprimé.');
    }
}