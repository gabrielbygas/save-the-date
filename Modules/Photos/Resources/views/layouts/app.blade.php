<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Save The Date - Commandez vos faire-part de mariage personnalisés.">
    <meta name="keywords" content="Save The Date, faire-part de mariage, mariage, invitations, personnalisation">
    <meta name="author" content="Gabriel KALALA">
    <meta name="robots" content="noindex">.

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
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
            &nbsp;<a href="{{ route('terms') }}" class="text-blue-600 underline">Conditions d'utilisation</a>&nbsp;
        </p>
    </footer>

</body>

</html>
