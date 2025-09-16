@extends('photos::layouts.app')

@section('content')
    <section class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
            <!-- Texte -->
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                    Collectez vos <span class="text-pink-600">souvenirs de mariage</span> avec notre QR Code
                </h1>
                <p class="mt-6 text-lg text-gray-600">
                    Créez et partagez votre album photo de mariage en ligne, simple d'utilisation pour vous et tous vos
                    invités.
                </p>
                <ul class="mt-6 space-y-3 text-gray-700">
                    <li>✅ Utilisation facile avec QR code privé</li>
                    <li>✅ Aucune inscription requise pour vos invités</li>
                    <li>✅ Nombre illimité de photos en haute qualité</li>
                    <li>✅ Jusqu'à 300 invités pour partager</li>
                </ul>
                <div class="mt-8">
                    <a href="{{ route('albums.create') }}"
                        class="px-6 py-3 bg-pink-600 text-white rounded-lg shadow hover:bg-pink-700">
                        Créer mon album photo mariage
                    </a>
                </div>
            </div>

            <!-- Mockup Image -->
            <div class="relative">
                <img src="{{ asset('images/qr_code.png') }}" alt="Mockup album photo" class="w-full rounded-2xl shadow-lg">
            </div>
        </div>
    </section>
@endsection
