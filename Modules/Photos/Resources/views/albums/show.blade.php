@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-pink-600">{{ $album->album_title }}</h2>
            <p class="text-gray-600 mt-2">📅 Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
            <p class="text-sm text-gray-500 mt-1">👥 Invités max : {{ $album->max_guests }}</p>
            <p class="text-sm text-gray-500">🔗 Lien de partage : <span class="font-mono">{{ route('albums.share', $album->share_url_token) }}</span></p>
            <p class="text-sm text-gray-500">Statut : <span class="uppercase font-bold text-pink-500">{{ $album->status }}</span></p>
        </div>

        @if ($album->qr_code_path)
            <div class="flex justify-center mb-6">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code" class="h-40 w-40 mx-auto">
                    <p class="text-sm text-gray-600 mt-2">Scannez pour accéder à l’album</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($album->photos as $photo)
                <div class="bg-gray-100 rounded shadow overflow-hidden">
                    <img src="{{ asset($photo->path) }}" alt="Photo de mariage" class="w-full h-48 object-cover">
                    <div class="p-2 text-sm text-gray-700">
                        {{ $photo->caption ?? 'Photo' }}
                    </div>
                </div>
            @empty
                <p class="col-span-4 text-center text-gray-500">Aucune photo ajoutée pour cet album.</p>
            @endforelse
        </div>
    </div>
@endsection
