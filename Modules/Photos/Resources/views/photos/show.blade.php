@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">{{ $album->album_title }}</h2>
            <!-- Afficher le couple -->
            <p class="text-lg font-semibold text-gray-800 mt-2"> Mariage de {{ ucfirst($album->client->mr_first_name) }} 💍
                {{ ucfirst($album->client->mrs_first_name) }}</p>
            <p class="text-sm md:text-base text-gray-600 mt-2">
                📅 Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}
            </p>
            <p class="text-gray-500 text-sm mt-2">📷 Détail d’une photo</p>
        </div>

        <div class="bg-gray-100 rounded-lg shadow overflow-hidden">
            <img src="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" alt="Photo"
                class="w-full max-h-[500px] object-contain">
            <div class="p-4 text-sm text-gray-700">
                <p><strong>Nom du fichier :</strong> {{ $photo->file_name }}</p>
                <p><strong>Taille :</strong> {{ number_format($photo->size_bytes / 1024, 2) }} KB</p>
                <p><strong>MIME :</strong> {{ $photo->mime }}</p>
                <p><strong>Ajoutée depuis :</strong> {{ $photo->created_at->format('d-m-Y') }}</p>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap space-x-2 md:space-x-4 justify-center">
            <!-- Bouton de retour -->
            <a href="{{ route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg font-bold hover:bg-gray-600 mt-2 md:mt-0">
                ⬅ Retour
            </a>

            <!-- Bouton de téléchargement -->
            <a href="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" download="{{ $photo->file_name }}"
                class="px-4 py-2 bg-green-500 text-white rounded-lg font-bold hover:bg-green-600 mt-2 md:mt-0">
                📥 Télécharger
            </a>

            <!-- Formulaire de suppression -->
            <form action="{{ route('photos.destroy', [$album->slug, $photo->id, 'owner_token' => $album->owner_token]) }}" method="POST"
                onsubmit="return confirm('Supprimer cette photo ?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold hover:bg-red-600 mt-2 md:mt-0">
                    🗑 Supprimer
                </button>
            </form>

        </div>

    </div>
@endsection
