<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save The Date - Mariages</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/ui@latest/dist/tailwind-ui.min.css">
</head>

<body class="bg-pink-50 text-gray-800 font-sans h-full">

    <div class="flex flex-col min-h-screen">

        <!-- Header -->
        <header class="bg-white shadow">
            <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-pink-600">Save The Date</h1>
                <a href="{{ route('order.create') }}"
                    class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded">
                    Commander
                </a>
            </div>
        </header>

        <!-- Main -->
        <main class="flex-grow max-w-4xl mx-auto mt-10 px-4">
            <section class="text-center mb-10">
                <h2 class="text-4xl font-bold text-pink-600">Créez vos affiches & vidéos de mariage</h2>
                <p class="text-lg mt-4 text-gray-700">
                    Immortalisez votre amour avec des designs personnalisés & livrés sous 72h max ! 📸💍
                </p>
            </section>

            <section class="grid md:grid-cols-3 gap-6 text-center">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-2">1. Remplissez le formulaire</h3>
                    <p class="text-sm text-gray-600">Choisissez un pack, un thème et envoyez vos infos.</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-2">2. Paiement sur WhatsApp</h3>
                    <p class="text-sm text-gray-600">Nous vous contactons pour les modalités de paiement.</p>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-2">3. Livraison rapide</h3>
                    <p class="text-sm text-gray-600">Vos affiches & vidéos vous seront livrées par mail & WhatsApp.</p>
                </div>
            </section>

            <div class="text-center mt-10">
                <a href="{{ route('order.create') }}"
                    class="inline-block bg-pink-500 text-white px-6 py-3 rounded-lg hover:bg-pink-600 transition">
                    Commencer ma commande
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 py-4 text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} Save The Date. Tous droits réservés. |
            <a href="{{ route('terms') }}" class="text-pink-600 hover:underline">Conditions d'utilisation</a>
        </footer>

    </div>

</body>

</html>
