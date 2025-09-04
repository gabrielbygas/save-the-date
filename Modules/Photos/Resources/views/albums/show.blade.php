@extends('photos::layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">{{ $album->album_title }}</h2>
            <p class="text-sm md:text-base text-gray-600 mt-2">📅 Mariage prévu le
                {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
            <p class="text-xs md:text-sm text-gray-500 mt-2">👥 Invités max : {{ $album->max_guests }}</p>
            <p class="text-xs md:text-sm text-gray-500 break-all mt-2">
                <span class="font-mono" id="share-link-text">{{ route('albums.share', $album->share_url_token) }}</span>
            </p>
            <p class="text-xs md:text-sm text-gray-500 mt-2">Statut : <span
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
                        <button class="px-3 py-2 bg-purple-500 text-white rounded-lg font-bold text-sm hover:bg-purple-600 transition">
                            <a href="{{ asset('storage/' . $album->qr_code_path) }}" download="qrcode-{{ $album->slug }}.png">
                                📥 Télécharger le QR Code
                            </a>
                       </button>

                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse ($album->photos as $photo)
                <div class="bg-gray-100 rounded shadow overflow-hidden">
                    <img src="{{ asset($photo->path) }}" alt="Photo de mariage" class="w-full h-32 md:h-48 object-cover">
                    <div class="p-2 text-xs md:text-sm text-gray-700">
                        {{ $photo->caption ?? 'Photo' }}
                    </div>
                </div>
            @empty
                <p class="col-span-2 md:col-span-3 lg:col-span-4 text-center text-gray-500">Aucune photo ajoutée pour cet
                    album.</p>
            @endforelse
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
