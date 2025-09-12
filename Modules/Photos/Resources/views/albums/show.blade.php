@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">Album: {{ $album->album_title }}</h2>
            <p class="text-lg font-semibold text-gray-800 mt-2"> Mariage de {{ ucfirst($client->mr_first_name) }} 💍
                {{ ucfirst($client->mrs_first_name) }}</p>
            <p class="text-sm md:text-base text-gray-600 mt-2">📅 Mariage prévu le
                {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
            <p class="text-xs md:text-sm text-gray-500 mt-2">👥 Invités max : {{ $album->max_guests }}</p>
            <p class="text-xs md:text-sm text-gray-500 break-all mt-4">
                <span class="font-mono" id="share-link-text">{{ route('albums.share', $album->share_url_token) }}</span>
            </p>
            <p class="text-xs md:text-sm text-gray-500 mt-4">Statut : <span
                    class="uppercase font-bold text-pink-500">{{ $album->status }}</span></p>
        </div>

        @if ($album->qr_code_path)
            <div class="flex flex-col items-center mb-6">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code"
                        class="w-32 h-32 md:w-40 md:h-40 mx-auto">
                    <p class="text-sm text-gray-600 mt-2">Scannez pour accéder à l’album</p>
                    <div class="mt-4 flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4">
                        {{-- Bouton pour copier le lien --}}
                        <button onclick="copyShareLink()"
                            class="px-3 py-1 bg-pink-500 text-white rounded-lg font-bold text-sm hover:bg-pink-600 transition">
                            🔗 Copier le lien
                        </button>

                        {{-- Bouton pour télécharger l'image --}}
                        <button
                            class="px-3 py-2 bg-purple-500 text-white rounded-lg font-bold text-sm hover:bg-purple-600 transition">
                            <a href="{{ asset('storage/' . $album->qr_code_path) }}"
                                download="qrcode-{{ $album->slug }}.png">
                                📥 Télécharger le QR Code
                            </a>
                        </button>

                    </div>
                </div>
            </div>
        @endif

        <hr class="my-4"> <!-- DIVIDER -->

        <!-- ERREURS -->
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
        <!-- ERREURS -->

        <div class="m-4 md:m-8">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <!-- Bouton à gauche (pleine largeur sur mobile) -->
                <a href="{{ route('photos.index', $album->slug) }}"
                    class="w-full sm:w-auto px-4 py-2 bg-pink-500 text-white rounded-lg font-bold text-sm hover:bg-pink-600 transition text-center">
                    ← Voir les photos
                </a>

                <!-- Bouton à droite (pleine largeur sur mobile) -->
                <a href="{{ route('photos.create', $album->slug) }}"
                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-lg font-bold text-sm hover:bg-green-700 transition text-center">
                    📷 Ajouter des photos
                </a>
            </div>
        </div>

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
                                <a href="{{ route('photos.show', [$album->slug, $photo->id]) }}">
                                    <img src="{{ asset('storage/' . $photo->original_path) }}"
                                        alt="{{ $photo->caption ?? 'Photo' }}" class="w-full h-32 md:h-40 object-cover">
                                </a>

                                <!-- Overlay avec boutons -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center
                                    opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('photos.show', [$album->slug, $photo->id]) }}"
                                            class="p-2 bg-white text-pink-600 rounded-full shadow-md
                                          hover:bg-gray-100 transition flex items-center justify-center"
                                            title="Voir la photo">
                                            🔍
                                        </a>
                                        <a href="{{ asset('storage/' . $photo->original_path) }}"
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

    <script>
        function copyShareLink() {
            const shareLinkText = document.getElementById('share-link-text');
            const range = document.createRange();
            range.selectNode(shareLinkText);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            document.execCommand('copy');
            alert('Lien copié dans le presse-papiers !');
            window.getSelection().removeAllRanges();
        }
    </script>
@endsection
