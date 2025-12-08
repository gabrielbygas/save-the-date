<!-- resources/views/photos/albums/login.blade.php -->
@extends('photos::layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <h1 class="text-2xl font-bold text-center mb-6">Accès aux Albums</h1>

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire pour demander un OTP -->
        <form id="otpForm" action="{{ route('albums.send_otp') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="identifier" class="block text-sm font-medium text-gray-700">Email ou Téléphone</label>
                <input type="text" name="identifier" id="identifier" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500">
            </div>
            <button type="submit"
                class="w-full bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                Envoyer le code OTP
            </button>
        </form>

        <!-- Formulaire pour vérifier l'OTP (caché au début) -->
        <form id="verifyOTPForm" action="{{ route('albums.verify_otp') }}" method="POST" class="space-y-4 mt-6 hidden">
            @csrf
            <input type="hidden" name="identifier" id="hiddenIdentifier">
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Code OTP</label>
                <input type="text" name="otp" id="otp" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500"
                    placeholder="Ex: ABCD1234">
            </div>
            <button type="submit"
                class="w-full bg-pink-600 text-white py-2 px-4 rounded-md hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
                Vérifier le code
            </button>
        </form>
    </div>

    <script>
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const identifier = form.querySelector('[name="identifier"]').value;

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        identifier
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data
                            .message); // En production, utilise un toast ou une notification plus élégante
                        document.getElementById('hiddenIdentifier').value = identifier;
                        document.getElementById('otpForm').classList.add('hidden');
                        document.getElementById('verifyOTPForm').classList.remove('hidden');
                    } else {
                        alert('Erreur : ' + (data.message || 'Une erreur est survenue.'));
                    }
                })
                .catch(error => {
                    alert('Erreur : ' + error.message);
                });
        });
    </script>
@endsection
