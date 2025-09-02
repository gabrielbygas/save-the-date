<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - @yield('title')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-bold text-pink-600">SaveTheDate Photos</a>
        <nav>
            <a href="{{ route('albums.index') }}" class="ml-4 text-gray-700 hover:text-pink-600">Albums</a>
            <a href="{{ route('payments.checkout') }}" class="ml-4 text-gray-700 hover:text-pink-600">Paiement</a>
        </nav>
    </header>

    <!-- Content -->
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center py-4 mt-10 text-sm text-gray-600">
        &copy; {{ date('Y') }} SaveTheDate Photos - Tous droits réservés
    </footer>
</body>
</html>
