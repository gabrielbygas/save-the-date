{{-- modify by claude --}}
{{-- Footer - Composant reutilisable --}}

<footer class="bg-gray-900 text-white mt-auto">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section principale du footer --}}
        <div class="py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Colonne 1: A propos --}}
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <img src="{{ asset('images/savethedate.webp') }}" alt="Logo" class="h-10 brightness-0 invert opacity-90">
                    <span class="text-lg font-bold text-pink-400">Save The Date</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Creez des souvenirs inoubliables pour votre mariage avec nos affiches personnalisees et albums photo partageables.
                </p>
            </div>

            {{-- Colonne 2: Liens rapides --}}
            <div>
                <h3 class="text-sm font-semibold text-pink-400 uppercase tracking-wider mb-4">Liens rapides</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('order.create') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Affiches & Videos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('albums.create') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Album Photo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white transition-colors duration-200 text-sm">
                            Conditions d'utilisation
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Colonne 3: Contact --}}
            <div>
                <h3 class="text-sm font-semibold text-pink-400 uppercase tracking-wider mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-sm text-gray-400">
                        <svg class="h-4 w-4 mr-2 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:contact@savethedate.com" class="hover:text-white transition-colors duration-200">
                            contact@savethedate.com
                        </a>
                    </li>
                    <li class="flex items-center text-sm text-gray-400">
                        <svg class="h-4 w-4 mr-2 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>WhatsApp disponible</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-gray-800 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} <span class="text-pink-400 font-medium">Save The Date</span>. Tous droits reserves.
                </p>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-pink-400 transition-colors duration-200">
                        Confidentialite
                    </a>
                    <span class="text-gray-700">|</span>
                    <a href="{{ route('terms') }}" class="text-sm text-gray-500 hover:text-pink-400 transition-colors duration-200">
                        CGU
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
