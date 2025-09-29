<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save The Date - Créez vos affiches & albums photo de mariage</title>
    <meta name="description" content="Créez vos affiches, vidéos et albums photo de mariage personnalisés avec Save The Date. Livraison rapide et qualité professionnelle.">
    <meta name="keywords" content="Save The Date, faire-part mariage, affiches mariage, album photo mariage, vidéo mariage, personnalisation, QR code mariage">
    <meta name="author" content="Gabriel KALALA">
    <meta property="og:title" content="Save The Date - Créez vos souvenirs de mariage">
    <meta property="og:description" content="Immortalisez votre amour avec des affiches, vidéos et albums photo personnalisés pour votre mariage.">
    <meta property="og:image" content="{{ asset('images/savethedate.webp') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
    <style>
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
<body class="bg-pink-50 text-gray-800 font-sans h-full relative bg-opacity-70 antialiased"
      style="background-image: url('{{ asset('images/savethedate_bg2.webp') }}'); background-size: cover; background-position: center; background-attachment: fixed;">
    <div class="flex flex-col min-h-screen relative z-10">
        <!-- Header -->
        <header class="bg-white bg-opacity-95 shadow-md sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-pink-600">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/savethedate.webp') }}" alt="Logo Save The Date" class="h-10 mr-2">
                        Save The Date
                    </a>
                </h1>
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('order.create') }}"
                       class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                        Commander
                    </a>
                </nav>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-grow flex items-center justify-center px-4 py-10">
            <div class="w-full max-w-7xl space-y-16">
                <!-- Section Hero -->
                <section class="bg-white bg-opacity-95 rounded-3xl shadow-2xl p-8 text-center">
                    <h2 class="text-4xl md:text-5xl font-bold text-pink-600 mb-6">
                        Créez vos affiches & vidéos de mariage
                    </h2>
                    <p class="text-lg md:text-xl mt-4 text-gray-700 max-w-3xl mx-auto">
                        Immortalisez votre amour avec des designs <strong>uniques</strong> et une livraison sous <strong>72h max</strong> ! 📸💍
                    </p>
                    <div class="mt-10 grid md:grid-cols-3 gap-6 text-center">
                        <div class="bg-gray-50 bg-opacity-90 shadow-lg rounded-xl p-6 transform transition hover:scale-105">
                            <h3 class="text-xl font-semibold mb-3 text-pink-600">1. Remplissez le formulaire</h3>
                            <p class="text-sm text-gray-600">Choisissez un pack, un thème et envoyez vos infos.</p>
                        </div>
                        <div class="bg-gray-50 bg-opacity-90 shadow-lg rounded-xl p-6 transform transition hover:scale-105">
                            <h3 class="text-xl font-semibold mb-3 text-pink-600">2. Paiement sur WhatsApp</h3>
                            <p class="text-sm text-gray-600">Nous vous contactons pour les modalités de paiement sécurisé.</p>
                        </div>
                        <div class="bg-gray-50 bg-opacity-90 shadow-lg rounded-xl p-6 transform transition hover:scale-105">
                            <h3 class="text-xl font-semibold mb-3 text-pink-600">3. Livraison rapide</h3>
                            <p class="text-sm text-gray-600">Vos affiches & vidéos vous seront livrées par mail & WhatsApp.</p>
                        </div>
                    </div>
                    <div class="mt-10">
                        <a href="{{ route('order.create') }}"
                           class="inline-block bg-pink-500 text-white px-8 py-4 rounded-lg hover:bg-pink-600 transition duration-200 font-medium text-lg shadow-lg">
                            Commencer ma commande
                        </a>
                    </div>
                </section>

                <!-- Section Album Photo -->
                <section class="bg-gray-50 py-16 rounded-3xl">
                    <div class="max-w-7xl mx-auto px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Texte -->
                        <div class="text-left">
                            <h2 class="text-4xl font-extrabold text-gray-900 leading-tight mb-6">
                                Collectez vos <span class="text-pink-600">souvenirs de mariage</span> avec notre QR Code
                            </h2>
                            <p class="text-lg text-gray-600 mb-6">
                                Créez et partagez votre album photo de mariage en ligne, simple d'utilisation pour vous et tous vos invités.
                            </p>
                            <ul class="space-y-3 text-gray-700 mb-8">
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Utilisation facile avec QR code privé
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Aucune inscription requise pour vos invités
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Nombre illimité de photos en haute qualité
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Jusqu'à 300 invités pour partager
                                </li>
                            </ul>
                            <div>
                                <a href="{{ route('albums.create') }}"
                                   class="px-8 py-4 bg-pink-500 text-white rounded-lg shadow-lg hover:bg-pink-600 transition duration-200 font-medium text-lg">
                                    Créer mon album photo mariage
                                </a>
                            </div>
                        </div>
                        <!-- Mockup Image -->
                        <div class="relative">
                            <img src="{{ asset('images/qr_code.png') }}" alt="Exemple d'album photo mariage avec QR Code"
                                 class="w-full rounded-2xl shadow-xl border-4 border-white">
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 py-6 text-center text-sm text-gray-600 mt-10">
            <div class="max-w-6xl mx-auto px-4">
                <p class="mb-2">
                    &copy; {{ date('Y') }} <a href="{{ route('home') }}" class="text-pink-600 hover:underline font-medium">Save The Date</a>. Tous droits réservés.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('terms') }}" class="text-pink-600 hover:underline">Conditions d'utilisation</a>
                    <span class="text-gray-400">|</span>
                    <a href="mailto:contact@savethedate.com" class="text-pink-600 hover:underline">Contact</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Script pour les alertes (si besoin) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('alert-success');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('hide');
                    setTimeout(function() { successAlert.remove(); }, 500);
                }, 5000);
            }

            const errorAlert = document.getElementById('alert-error');
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.classList.add('hide');
                    setTimeout(function() { errorAlert.remove(); }, 500);
                }, 10000);
            }
        });
    </script>
</body>
</html>
