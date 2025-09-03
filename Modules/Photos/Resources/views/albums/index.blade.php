@extends('photos::layouts.app')

@section('content')
    <div class="p-6 bg-white shadow rounded-xl mt-8">
        <div class="text-center mb-8 bg-white p-6 rounded-lg shadow">
            <h2 class="text-3xl font-bold text-pink-600">Mes albums de mariage</h2>
            <p class="text-gray-600 mt-2">Retrouvez tous vos souvenirs en un seul endroit</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 bg-white">
            @forelse ($albums as $album)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $album->couple_names }}</h3>
                        <p class="text-sm text-gray-500">📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500">👥 {{ $album->max_guests }} invités max</p>
                        <p class="text-sm text-gray-500">🔗 <span class="font-mono">{{ route('albums.share', $album->share_url_token) }}</span></p>
                        <p class="mt-2 text-xs text-gray-400">Statut : <span class="uppercase font-bold text-pink-500">{{ $album->status }}</span></p>
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
