<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="description" content="Créez vos affiches, vidéos et albums photo de mariage personnalisés avec Save The Date. Livraison rapide et qualité professionnelle.">
    <meta name="keywords" content="Save The Date, faire-part mariage, affiches mariage, album photo mariage, vidéo mariage, personnalisation, QR code mariage">
    <meta name="author" content="Gabriel KALALA">
    <meta property="og:title" content="Save The Date - Créez vos souvenirs de mariage">
    <meta property="og:description" content="Immortalisez votre amour avec des affiches, vidéos et albums photo personnalisés pour votre mariage.">
    <meta property="og:image" content="{{ asset('images/savethedate.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <title>Save The Date - Créez vos affiches & albums photo de mariage</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">

    <!-- style de message succes / error -->
    <style>
        /* Animation pour la disparition */
        .fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        .fade-out.hide {
            opacity: 0;
            height: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased"
    style="background-image: url('{{ asset('images/savethedate_bg3.webp') }}'); background-size: cover; background-position: center;">

    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-600"><a href="{{ route('photos.home') }}">Save The Date</a></h1>
            <a href="{{ route('photos.home') }}"><img src="{{ asset('images/savethedate.webp') }}" alt="Logo"
                    class="h-16"></a>
            <a href="{{ route('albums.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                Créer un album</a>
        </div>
    </header>

    <div class="min-h-screen items-center justify-center rounded-4" style="max-width: 1080px; margin: 0 auto;">

        <main class="py-4 px-4 rounded-9" style="margin: 0 auto;">
            @yield('content')
        </main>
    </div>

    <!-- Pied de page -->
    <footer class="bg-white shadow text-center mt-8 text-sm text-gray-500 py-2">
        <p class="mb-2"> <a href="mailto:gabrielkalala@protonmail.com"
                class="text-blue-600 underline">gabrielkalala@protonmail.com</a>&nbsp;|
            &nbsp;© {{ date('Y') }} <span class="text-gray-800">Save The Date</span> Tous droits réservés&nbsp;|
            &nbsp;<a href="{{ route('terms') }}" class="text-blue-600 underline">Conditions Générales
                d'Utilisation</a>&nbsp;
        </p>
    </footer>

    <!-- affichage message succes / error -->
    <script> 
        document.addEventListener('DOMContentLoaded', function() {
            // Masquer le message de succès après 5 secondes
            const successAlert = document.getElementById('alert-success');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('hide');
                    setTimeout(function() {
                        successAlert.remove();
                    }, 500); // Supprime l'élément après l'animation
                }, 5000); // 5 secondes
            }

            // Masquer le message d'erreur après 10 secondes
            const errorAlert = document.getElementById('alert-error');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.classList.add('hide');
                    setTimeout(function() {
                        errorAlert.remove();
                    }, 500); // Supprime l'élément après l'animation
                }, 10000); // 10 secondes
            }
        });
    </script>

</body>

</html>
