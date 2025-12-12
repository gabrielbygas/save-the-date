{{-- modify by claude --}}
{{-- Menu mobile - Panel coulissant avec overlay --}}

{{-- Overlay sombre --}}
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity duration-300 opacity-0"></div>

{{-- Panel coulissant --}}
<nav id="mobile-menu" class="fixed top-0 right-0 h-full w-72 max-w-[80vw] bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden">
    {{-- Header du menu --}}
    <div class="flex items-center justify-between p-4 border-b border-gray-100">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/savethedate.webp') }}" alt="Logo" class="h-8">
            <span class="text-lg font-bold text-pink-600">Menu</span>
        </div>
        <button type="button" id="mobile-menu-close"
            class="p-2 rounded-lg text-gray-500 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500">
            <span class="sr-only">Fermer le menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Liens de navigation --}}
    <div class="py-4 px-2">
        <a href="{{ route('home') }}"
            class="flex items-center px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('home') ? 'text-pink-600 bg-pink-50' : '' }}">
            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Accueil
        </a>

        <a href="{{ route('order.create') }}"
            class="flex items-center px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('order.*') ? 'text-pink-600 bg-pink-50' : '' }}">
            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Affiches & Videos
        </a>

        <a href="{{ route('albums.create') }}"
            class="flex items-center px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-lg font-medium transition-colors duration-200 {{ request()->routeIs('albums.*') ? 'text-pink-600 bg-pink-50' : '' }}">
            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Album Photo
        </a>

        {{-- Separateur --}}
        <div class="my-4 border-t border-gray-100"></div>

        {{-- Bouton CTA --}}
        <div class="px-2">
            <a href="{{ route('order.create') }}"
                class="flex items-center justify-center w-full bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-4 py-3 rounded-lg font-medium transition-all duration-300 shadow-md">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Commander maintenant
            </a>
        </div>
    </div>

    {{-- Footer du menu mobile --}}
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-gray-50">
        <p class="text-xs text-gray-500 text-center">
            &copy; {{ date('Y') }} Save The Date
        </p>
    </div>
</nav>
