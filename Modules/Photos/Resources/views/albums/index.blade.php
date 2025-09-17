@extends('photos::layouts.app')

@section('content')
    <div class="p-6 bg-white shadow rounded-xl mt-8">
        <div class="text-center mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-3xl font-bold text-pink-600">Mes albums de mariage</h2>
            <p class="text-gray-600 mt-2">Retrouvez tous vos souvenirs en un seul endroit</p>
        </div>

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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 bg-white">
            @forelse ($albums as $album)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ ucfirst($album->client->mr_first_name) }} 💍
                            {{ ucfirst($album->client->mrs_first_name) }}</h3>
                        <p class="text-sm md:text-base text-gray-500 mt-4">Album : {{ $album->album_title }}</p>
                        <p class="text-sm text-gray-500">📅
                            {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500">👥 {{ $album->max_guests }} invités max</p>
                        <p class="text-sm text-gray-500">🔗 <span
                                class="font-mono">{{ route('albums.share', $album->share_url_token) }}</span></p>
                        <p class="mt-2 text-xs text-gray-400">Statut : <span
                                class="uppercase font-bold text-pink-500">{{ $album->status }}</span></p>
                    </div>
                    <div class="px-4 pb-4 flex justify-between items-center">
                        <a href="{{ route('albums.show', $album->slug) }}"
                            class="bg-pink-500 hover:bg-pink-600 text-white text-sm px-4 py-2 rounded">
                            Voir l’album
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 col-span-3">Aucun album pour le moment.</p>
            @endforelse
        </div>
    </div>
@endsection
