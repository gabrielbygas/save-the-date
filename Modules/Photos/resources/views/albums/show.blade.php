@extends('layouts.app')

@section('title', $album->title)

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-pink-600">{{ $album->title }}</h1>
    <p class="mb-4 text-gray-700">{{ $album->description }}</p>

    <!-- QR Code -->
    <div class="mb-6 text-center">
        <h2 class="text-lg font-semibold mb-2">Partagez avec vos invités</h2>
        <img src="{{ route('albums.qrcode', $album->id) }}" alt="QR Code" class="mx-auto w-40 h-40">
        <p class="text-sm text-gray-600 mt-2">Scannez pour accéder à l’album</p>
    </div>

    <!-- Galerie Photos -->
    <h2 class="text-xl font-semibold mb-4">Photos</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse ($album->photos as $photo)
            <a href="{{ route('photos.show', [$album->id, $photo->id]) }}">
                <img src="{{ asset('storage/' . $photo->path) }}" class="rounded-lg shadow hover:scale-105 transition">
            </a>
        @empty
            <p class="col-span-4 text-gray-500">Aucune photo pour le moment.</p>
        @endforelse
    </div>

    <!-- Upload bouton -->
    <div class="mt-6">
        <a href="{{ route('photos.upload', $album->id) }}" 
           class="bg-pink-600 text-white px-4 py-2 rounded-lg shadow hover:bg-pink-700">
           Ajouter des photos
        </a>
    </div>
</div>
@endsection
