@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">Invitation à l'Album: {{ $album->album_title }}
            </h2>
            <p class="text-xl font-semibold text-gray-800 mt-2"> Mariage de {{ ucfirst($client->mr_first_name) }}
                {{ ucfirst($client->mr_last_name) }} 💍
                {{ ucfirst($client->mrs_first_name) }} {{ ucfirst($client->mrs_last_name) }}</p>
            <p class="text-sm md:text-base text-gray-600 mt-2">📅 Mariage prévu le
                {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
        </div>

        <hr class="my-10"> <!-- DIVIDER -->

        <div class="text-center mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ ucfirst($client->mr_first_name) }} &
                {{ ucfirst($client->mrs_first_name) }} vous invitent à partager vos
                souvenirs de leur mariage</h3>
            <p class="text-gray-600 mb-4">Pour ajouter vos photos, veuillez fournir les informations suivantes :</p>
            <div class="flex items-center justify-center">
                <form action="{{ route('albums.request_upload_token', $album->slug) }}" method="POST">
                    @csrf

                    <!-- ERREURS -->
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Gère les messages d'erreur de session --}}
                    @if (session('error'))
                        <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                            <div class="list-disc pl-5 space-y-1">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    {{-- Gère les erreurs de validation du formulaire --}}
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                {{-- Cette partie est redondante si vous utilisez $errors->all() --}}
                                {{-- @error('photos.0')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror --}}
                            </ul>
                        </div>
                    @endif
                    <!-- ERREURS -->

                    <div class="mb-4">
                        <label class="block">Votre Nom *</label>
                        <input type="text" name="visitor_name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                            value="{{ old('visitor_name') }}" placeholder="John Doe" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mt-4">Email *</label>
                        <input type="email" name="visitor_email" class="w-full border p-2 rounded"
                            value="{{ old('email') }}" placeholder="exemple@domaine.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mt-4">Numéro Whatsapp *</label>
                        <input type="text" name="visitor_phone" class="w-full border p-2 rounded"
                            value="{{ old('phone') }}" placeholder="+243xxxxxxxxx" required>
                    </div>
                    <!-- Case à cocher pour acceptation des CGU -->
                    <div class="mb-4 mt-6">
                        <label class="flex items-center space-x-2">
                            <span class="text-sm">
                                En soumettant ce formulaire, vous acceptez les <a href="{{ route('terms') }}"
                                    target="_blank" class="text-blue-600 underline">Conditions Générales d'Utilisation</a>
                            </span>
                        </label>
                    </div>
                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-semibold px-6 py-2 rounded-md">
                            Recevoir le lien d'upload
                        </button>
                    </div>
                </form>
            </div>
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
