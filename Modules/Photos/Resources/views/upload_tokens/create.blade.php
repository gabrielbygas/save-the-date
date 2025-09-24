@extends('photos::layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8">
        <div class="text-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-pink-600 break-words">
                Ajouter des photos à l'album : {{ $album->album_title }}
            </h2>
            <p class="text-xl font-semibold text-gray-800 mt-2"> Mariage de {{ ucfirst($album->client->mr_first_name) }}
                {{ ucfirst($album->client->mr_last_name) }} 💍
                {{ ucfirst($album->client->mrs_first_name) }} {{ ucfirst($album->client->mrs_last_name) }}</p>
            <p class="text-sm md:text-base text-gray-600 mt-2">
                📅 Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}
            </p>
        </div>

        <form action="{{ route('photos.invite.store', [$album->slug, $uploadToken->token]) }}" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <input type="file" name="photos[]" id="photos" class="hidden" multiple
                    accept="image/jpeg,image/png,image/jpg,image/gif" required>
                <label for="photos" class="cursor-pointer">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600 font-bold">
                        {{ ucfirst($uploadToken->visitor_name) }}
                        <span class="font-bold text-pink-700 hover:text-pink-500">
                            Cliquez pour sélectionner des photos
                        </span>
                        ou glissez-déposez
                    </p>
                    <p class="mt-2 text-xs text-gray-600">
                        Vous pouvez uploader maximum de 5 photos JPEG, PNG, JPG ou GIF (max 10MB par photo)
                    </p>

                    <p class="hidden" id="file-upload-info"> </p>
                </label>
            </div>

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
                    </ul>
                </div>
            @endif
            <!-- ERREURS -->

            <div id="upload-error" class="hidden bg-red-100 text-red-800 p-4 mb-4 rounded text-center"></div>

            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-pink-600 text-white rounded-lg font-bold hover:bg-pink-700 transition">
                    Uploader les photos
                </button>
            </div>
        </form>

        <hr class="my-10 mt-10"> <!-- DIVIDER -->

        <div class="m-8 flex justify-end">
            <a href="{{ route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold text-sm hover:bg-green-700 transition">
                ✨ Voir les photos
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const fileInput = document.getElementById('photos');
            const errorBox = document.getElementById('upload-error');
            const fileUploadInfo = document.getElementById('file-upload-info');

            form.addEventListener('submit', function(e) {
                const files = fileInput.files;
                if (files.length > 10) {
                    e.preventDefault();
                    errorBox.textContent = "🚫 Vous ne pouvez pas uploader plus de 10 photos à la fois.";
                    errorBox.classList.remove('hidden');
                    fileUploadInfo.classList.add('hidden');
                    fileUploadInfo.textContent = '';
                    return false;
                }
            });

            fileInput.addEventListener('change', function(e) {
                const files = e.target.files;

                // Réinitialiser les messages
                errorBox.classList.add('hidden');
                errorBox.textContent = '';
                fileUploadInfo.classList.add('hidden');
                fileUploadInfo.textContent = '';

                if (files.length > 10) {
                    errorBox.textContent = "🚫 Vous avez sélectionné " + files.length +
                        " fichiers. Maximum autorisé : 10.";
                    errorBox.classList.remove('hidden');
                    return;
                }

                if (files.length > 0) {
                    const fileNames = Array.from(files).map(file => file.name).join(', ');
                    fileUploadInfo.textContent = `📷 Photos sélectionnées : ${fileNames}`;
                    fileUploadInfo.classList.remove('hidden');
                }
            });
        });
    </script>
@endsection
