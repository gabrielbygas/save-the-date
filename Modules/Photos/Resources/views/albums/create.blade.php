@extends('photos::layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-pink-600 mb-4 text-center">Créer un nouvel album de mariage</h2>
        <p class="text-sm text-gray-600 text-center mb-6">Immortalisez votre amour et partagez vos souvenirs avec vos invités
            💍</p>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @error('photos.0')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </ul>
            </div>
        @endif

        <form action="{{ route('albums.store') }}" method="POST">
            @csrf

            {{-- Coordonnées de Monsieur --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block">Prénom Monsieur *</label>
                    <input type="text" name="mr_first_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                        value="{{ old('mr_first_name') }}" placeholder="John" required>
                </div>
                <div class="mb-4">
                    <label class="block">Nom Monsieur *</label>
                    <input type="text" name="mr_last_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                        value="{{ old('mr_last_name') }}" placeholder="Doe" required>
                </div>
            </div>

            {{-- Coordonnées de Madame --}}
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div class="mb-4">
                    <label class="block">Prénom Madame *</label>
                    <input type="text" name="mrs_first_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                        value="{{ old('mrs_first_name') }}" placeholder="Jane" required>
                </div>
                <div class="mb-4">
                    <label class="block">Nom Madame *</label>
                    <input type="text" name="mrs_last_name"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                        value="{{ old('mrs_last_name') }}" placeholder="Kayla" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="album_title" class="block text-gray-700 font-medium mb-1">Titre album *</label>
                <input type="text" name="album_title" id="album_title"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
            </div>

            <div class="mb-4">
                <label class="block mt-4">Email *</label>
                <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}"
                    placeholder="exemple@domaine.com" required>
            </div>

            <div class="mb-4">
                <label class="block mt-4">Numéro Whatsapp *</label>
                <input type="text" name="phone" class="w-full border p-2 rounded" value="{{ old('phone') }}"
                    placeholder="+243xxxxxxxxx" required>
            </div>

            <div class="mb-4">
                <label for="wedding_date" class="block text-gray-700 font-medium mb-1">Date du mariage *</label>
                <input type="date" name="wedding_date" id="wedding_date"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
            </div>

            <div class="mb-4">
                <label for="max_guests" class="block text-gray-700 font-medium mb-1">Nombre d'invités (max:300) *</label>
                <input type="number" name="max_guests" id="max_guests" value="150" max="300"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500" required>
            </div>

            <input type="hidden" name="status" value="draft">

            <!-- Case à cocher pour acceptation des CGU -->
            <div class="mb-4 mt-6">
                <label class="flex items-center space-x-2">
                    <span class="text-sm">
                        En soumettant ce formulaire, vous acceptez les <a href="{{ route('terms') }}" target="_blank"
                            class="text-blue-600 underline">Conditions Générales d'Utilisation</a>
                    </span>
                </label>
            </div>

            <div class="mt-6 text-center">
                <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-md">
                    Créer mon album
                </button>
            </div>
        </form>
    </div>
@endsection
