<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Save The Date - Commandez vos faire-part de mariage personnalisés.">
    <meta name="keywords"
        content="Save The Date, faire-part mariage, mariage, affiches mariage, invitations, personnalisation">
    <meta name="author" content="Gabriel KALALA">
    <meta name="robots" content="noindex">
    <meta property="og:title" content="Save The Date - Créez vos souvenirs de mariage">
    <meta property="og:description"
        content="Immortalisez votre amour avec des affiches, vidéos et albums photo personnalisés pour votre mariage.">
    <meta property="og:image" content="{{ asset('images/savethedate.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <title>Save The Date - Créez vos affiches</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
</head>

<body class="font-sans antialiased"
    style="background-image: url('{{ asset('images/savethedate_bg1.webp') }}'); background-size: cover; background-position: center;">

    <!-- Header with Logo -->
    {{-- <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-center">
            <a href="{{ route('home') }}"><img src="{{ asset('images/savethedate.webp') }}" alt="Logo" class="h-16"></a>
        </div>
    </header> --}}
    <header class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-pink-600"><a href="{{ route('home') }}">Save The Date</a></h1>
            <a href="{{ route('home') }}"><img src="{{ asset('images/savethedate.webp') }}" alt="Logo"
                    class="h-16"></a>
            <a href="{{ route('order.create') }}" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                Commander </a>
        </div>
    </header>

    <div class="min-h-screen items-center justify-center rounded-4" style="max-width: 980px; margin: 0 auto;">

        <!-- Page Heading -->
        {{-- @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset --}}

        <!-- Page Content -->
        <main class="py-4 px-4 rounded-9" style="margin: 0 auto;">
            @yield('content')
        </main>
    </div>

    <!-- Pied de page -->
    <footer class="bg-gray-100 py-6 text-center text-sm text-gray-600 mt-10">
        <div class="max-w-6xl mx-auto px-4">
            <p class="mb-2">
                &copy; {{ date('Y') }} <a href="{{ route('home') }}"
                    class="text-pink-600 hover:underline font-medium">Save The Date</a>. Tous droits réservés.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('terms') }}" class="text-pink-600 hover:underline">Conditions d'utilisation</a>
                <span class="text-gray-400">|</span>
                <a href="mailto:contact@savethedate.com" class="text-pink-600 hover:underline">Contact</a>
            </div>
        </div>
    </footer>

</body>

</html>
