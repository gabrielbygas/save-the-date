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
            </ul>
        </div>
    @endif


    <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Coordonnées de Monsieur --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block">Prénom (Monsieur) *</label>
                <input type="text" name="mr_first_name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Nom (Monsieur) *</label>
                <input type="text" name="mr_last_name" class="w-full border p-2 rounded" required>
            </div>
        </div>

        {{-- Coordonnées de Madame --}}
        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block">Prénom (Madame) *</label>
                <input type="text" name="mrs_first_name" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block">Nom (Madame) *</label>
                <input type="text" name="mrs_last_name" class="w-full border p-2 rounded" required>
            </div>
        </div>

        <label class="block mt-4">Email *</label>
        <input type="email" name="email" class="w-full border p-2 rounded" required>

        <label class="block mt-4">Téléphone *</label>
        <input type="text" name="phone" class="w-full border p-2 rounded">

        <label class="block mt-4">Date du mariage *</label>
        <input type="date" name="wedding_date" class="w-full border p-2 rounded" required>

        <label class="block mt-4">Lieu du mariage *</label>
        <input type="text" name="wedding_location" class="w-full border p-2 rounded" required>

        {{-- Sélections --}}
        <label class="block mt-4">Pack *</label>
        <select name="pack_id" class="w-full border p-2 rounded" required>
            @foreach ($packs as $pack)
                <option value="{{ $pack->id }}">{{ $pack->name }} - {{ number_format($pack->price, 2) }}$</option>
            @endforeach
        </select>

        <label class="block mt-4">Thème *</label>
        <select name="theme_id" class="w-full border p-2 rounded">
            <option value="">-- Aucun --</option>
            @foreach ($themes as $theme)
                <option value="{{ $theme->id }}">{{ $theme->name }}</option>
            @endforeach
        </select>

        {{-- Upload --}}
        <label class="block mt-4">Medias (JPG/PNG max 2Mo, MP4/MOV max 20Mo, max 5 fichiers)</label>
        <input type="file" name="photos[]" multiple class="w-full border p-2 rounded" onchange="validateFiles(this)">

        <button type="submit" class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Envoyer la commande
        </button>
    </form>
</div>

<script>
    function validateFiles(input) {
        const files = input.files;
        if (files.length > 5) {
            alert('Vous ne pouvez télécharger que 5 fichiers maximum.');
            input.value = ''; // Reset the input
            return;
        }
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!['image/jpeg', 'image/png', 'video/mp4', 'video/mov', 'video/ogg'].includes(file.type)) {
                alert('Seuls les fichiers JPG, PNG, MP4, MOV et OGG sont autorisés.');
                input.value = ''; // Reset the input
                return;
            }
            if (file.size > 20971520) { // 20 Mo
                alert('Chaque fichier ne doit pas dépasser 20 Mo.');
                input.value = ''; // Reset the input
                return;
            }
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[type="file"]');
        fileInput.addEventListener('change', function() {
            const fileCount = this.files.length;
            alert(`${fileCount} fichier(s) sélectionné(s).`);
        });
    });
</script>

@endsection