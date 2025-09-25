@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">
                Photos de l'album : {{ $album->album_title }}
            </h2>
            <!-- Afficher le couple -->
            <p class="text-lg font-semibold text-gray-800 mt-2"> Mariage de {{ ucfirst($client->mr_first_name) }} 💍
                {{ ucfirst($client->mrs_first_name) }}</p>
            <p class="text-sm md:text-base text-gray-600 mt-2">
                📅 Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}
            </p>
            <p class="text-xs md:text-sm text-gray-500 mt-2">📷 {{ $photos->count() }} photo(s)</p>
        </div>

        <hr class="my-10 mt-10"> <!-- DIVIDER -->

        <!-- ERREURS -->
        @if (session('success'))
            <div id="alert-success" class="bg-green-100 text-green-700 p-3 mb-4 rounded fade-out">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div id="alert-error" class="bg-red-100 text-red-800 p-4 mb-4 rounded fade-out">
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
        <!-- ERREURS -->

        @if(!$uploadToken->used) <!-- si le token n'est pas utilise ou photos_count <=5 -->
            <div class="m-4 md:m-8">
                <div class="flex flex-col sm:flex-row justify-end">
                    <!-- Bouton à droite (pleine largeur sur mobile) -->
                    <a href="{{ route('photos.invite.upload', [$album->slug, $uploadToken->token]) }}"
                        class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg font-bold text-sm hover:bg-green-700 transition text-center">
                        📷 Ajouter des photos
                    </a>
                </div>
            </div>
        @else <!-- si le token est utilise ou photos_count >=5 -->
            <div class="m-4 md:m-8">
                <div class="flex flex-col sm:flex-row bg-red-100 text-red-800 p-4 mb-4 rounded justify-end">
                    <span>Pas de possibilite d'ajouter des nouvelles photos. Vous avez déjà uploadé le nombre maximal de 5 photos autorisées.</span>
                </div>
            </div>
        @endif


        <!-- Galerie de photos -->
        <div id="photos-gallery" class="mt-6">
            @if ($photos->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Aucune photo dans cet album.</p>
                </div>
            @else
                <div
                    class="max-h-[70vh] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-pink-500 scrollbar-track-gray-100">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
                        @foreach ($photos as $photo)
                            <div class="bg-gray-100 rounded-lg shadow overflow-hidden group relative">
                                <a
                                    href="{{ route('photos.show', [$album->slug, $photo->id, 'owner_token' => $album->owner_token]) }}">
                                    <img src="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}"
                                        alt="{{ $photo->caption ?? 'Photo' }}" class="w-full h-32 md:h-40 object-cover">

                                </a>

                                <!-- Overlay avec boutons -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center
                                    opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('photos.show', [$album->slug, $photo->id, 'owner_token' => $album->owner_token]) }}"
                                            class="p-2 bg-white text-pink-600 rounded-full shadow-md
                                          hover:bg-gray-100 transition flex items-center justify-center"
                                            title="Voir la photo">
                                            🔍
                                        </a>
                                        <a href="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}"
                                            download="{{ $photo->file_name }}"
                                            class="p-2 bg-white text-blue-600 rounded-full shadow-md
                                          hover:bg-gray-100 transition flex items-center justify-center"
                                            title="Télécharger">
                                            📥
                                        </a>
                                    </div>
                                </div>

                                @if ($photo->caption)
                                    <div class="p-2 text-xs text-gray-700 truncate">
                                        {{ $photo->caption }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>


    </div>

    <!-- Style pour la scrollbar personnalisée -->s
    <style>
        /* Scrollbar personnalisée pour Chrome/Edge/Safari */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #ec4899;
            /* pink-500 */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #db2777;
            /* pink-600 */
        }

        /* Pour Firefox */
        scrollbar-width: thin;
        scrollbar-color: #ec4899 #f1f1f1;
    </style>


@endsection
