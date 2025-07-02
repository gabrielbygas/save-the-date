<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Save The Date - Commandez vos faire-part de mariage personnalisés.">
    <meta name="keywords" content="Save The Date, faire-part de mariage, mariage, invitations, personnalisation">
    <meta name="author" content="Gabriel KALALA">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased"
    style="background-image: url('{{ asset('images/savethedate_bg.png') }}'); background-size: cover; background-position: center;">

    <!-- Header with Logo -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-center">
            <img src="{{ asset('images/savethedate.png') }}" alt="Logo" class="h-16">
        </div>
    </header>

    <div class="min-h-screen items-center justify-center" style="max-width: 80%; margin: 0 auto;">

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="py-4 px-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
