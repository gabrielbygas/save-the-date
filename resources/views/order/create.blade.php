@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow rounded-xl mt-8">
    <h1 class="text-2xl font-bold mb-4">Passer une commande Save The Date</h1>

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


    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Coordonnées de Monsieur --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block">Prénom (Monsieur) *</label>
                <input type="text" name="mr_first_name" class="w-full border p-2 rounded" value="{{ old('mr_first_name') }}" required>
            </div>
            <div>
                <label class="block">Nom (Monsieur) *</label>
                <input type="text" name="mr_last_name" class="w-full border p-2 rounded" value="{{ old('mr_last_name') }}" required>
            </div>
        </div>

        {{-- Coordonnées de Madame --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block">Prénom (Madame) *</label>
                <input type="text" name="mrs_first_name" class="w-full border p-2 rounded" value="{{ old('mrs_first_name') }}" required>
            </div>
            <div>
                <label class="block">Nom (Madame) *</label>
                <input type="text" name="mrs_last_name" class="w-full border p-2 rounded" value="{{ old('mrs_last_name') }}" required>
            </div>
        </div>

        <label class="block mt-4">Email *</label>
        <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required>

        <label class="block mt-4">Numéro Whatsapp *</label>
        <input type="text" name="phone" class="w-full border p-2 rounded" value="{{ old('phone') }}" required>

        <label class="block mt-4">Date du mariage *</label>
        <input type="date" name="wedding_date" class="w-full border p-2 rounded" value="{{ old('wedding_date') }}" required>

        <label class="block mt-4">Lieu du mariage *</label>
        <input type="text" name="wedding_location" class="w-full border p-2 rounded" value="{{ old('wedding_location') }}" required>

        {{-- Sélections --}}
        <label class="block mt-4">Pack *</label>
        <select name="pack_id" class="w-full border p-2 rounded" required>
            @foreach ($packs as $pack)
                <option value="{{ $pack->id }}" {{ old('pack_id') == $pack->id ? 'selected' : '' }}>{{ $pack->name }} - {{ number_format($pack->price, 2) }}$</option>
            @endforeach
        </select>

        <label class="block mt-4">Thème *</label>
        <select name="theme_id" class="w-full border p-2 rounded">
            <option value="">-- Aucun --</option>
            @foreach ($themes as $theme)
                <option value="{{ $theme->id }}" {{ old('theme_id') == $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
            @endforeach
        </select>

        {{-- Upload --}}
        <label class="block mt-4">Medias (JPG/PNG max 2Mo, MP4/MOV max 20Mo, max 5 fichiers)</label>
        <input type="file" name="photos[]" multiple class="w-full border p-2 rounded" accept="image/jpeg,image/png,video/mp4,video/mov,video/ogg">
        <p class="text-sm text-gray-500 mt-1">Vous pouvez télécharger jusqu'à 5 fichiers au total, avec un maximum de 10 Mo par fichier.</p>

        {{-- Message --}}

        <!-- Case à cocher pour acceptation des CGU -->
        <div class="mb-4 mt-6">
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="terms" required class="form-checkbox text-indigo-600" 
                       {{ old('terms') ? 'checked' : '' }}>
                <span class="text-sm">
                    J'accepte les <a href="{{ route('terms') }}" target="_blank" class="text-blue-600 underline">Conditions Générales d'Utilisation</a>
                </span>
            </label>
        </div>

        <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Envoyer la commande
        </button>
    </form>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.querySelector('input[name="photos[]"]');

    fileInput.addEventListener('change', function () {
        const files = Array.from(fileInput.files);
        const maxFiles = 5;
        const allowedTypes = ['image/jpeg', 'image/png', 'video/mp4', 'video/mov', 'video/ogg'];
        const maxSize = 10 * 1024 * 20240; // 20MB

        // Vérifie le nombre de fichiers
        if (files.length > maxFiles) {
            alert(`Vous ne pouvez sélectionner que ${maxFiles} fichiers.`);
            fileInput.value = ''; // Annule la sélection
            return;
        }

        // Vérifie chaque fichier
        for (let file of files) {
            if (!allowedTypes.includes(file.type)) {
                alert(`Fichier non autorisé : ${file.name}`);
                fileInput.value = '';
                return;
            }
            if (file.size > maxSize) {
                alert(`Fichier trop volumineux (${file.name}) : max 10 Mo.`);
                fileInput.value = '';
                return;
            }
        }

    });
});
</script>


@endsection