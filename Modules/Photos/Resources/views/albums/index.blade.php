<!-- resources/views/photos/albums/index.blade.php -->
@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Albums de {{ ucfirst($client->mr_first_name) }} et
                {{ ucfirst($client->mrs_first_name) }}</h1>
            <a href="{{ route('albums.login') }}"
                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                Déconnexion
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($albums as $album)
                <div class="bg-gray-50 rounded-lg shadow p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $album->album_title }}</h2>
                    <p class="text-gray-600 mb-2">
                        Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}
                    </p>
                    <p class="text-gray-500 text-sm">
                        👥 {{ $album->uploadTokens()->count() }} invité(s) | 📷 {{ $album->photos()->count() }} photo(s)
                    </p>
                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('albums.show', $album->slug) }}"
                            class="px-3 py-1.5 bg-pink-600 text-white rounded-lg text-sm hover:bg-pink-700 transition">
                            Voir l'album
                        </a>
                        <a href="{{ route('albums.share', $album->share_url_token) }}"
                            class="px-3 py-1.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                            Partager
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-full text-center">Aucun album trouvé. <a
                        href="{{ route('albums.create') }}" class="text-pink-600">Créer un album</a></p>
            @endforelse
        </div>
    </div>
@endsection
