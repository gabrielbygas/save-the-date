{{-- modify by claude --}}
{{-- Header avec navigation - Composant reutilisable --}}

<header class="bg-white/95 backdrop-blur-sm shadow-md sticky top-0 z-50 transition-all duration-300" id="main-header">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            {{-- Logo et titre --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/savethedate.webp') }}" alt="Logo Save The Date"
                    class="h-12 sm:h-14 transition-transform duration-300 group-hover:scale-105">
                <span class="hidden sm:block text-xl font-bold text-pink-600 transition-colors duration-300 group-hover:text-pink-700">
                    Save The Date
                </span>
            </a>

            {{-- Navigation desktop --}}
            <nav class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-pink-500 hover:after:w-full after:transition-all after:duration-300 {{ request()->routeIs('home') ? 'text-pink-600 after:w-full' : '' }}">
                    Accueil
                </a>
                <a href="{{ route('order.create') }}"
                    class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-pink-500 hover:after:w-full after:transition-all after:duration-300 {{ request()->routeIs('order.*') ? 'text-pink-600 after:w-full' : '' }}">
                    Affiches & Videos
                </a>
                <a href="{{ route('albums.create') }}"
                    class="text-gray-700 hover:text-pink-600 font-medium transition-colors duration-200 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-pink-500 hover:after:w-full after:transition-all after:duration-300 {{ request()->routeIs('albums.*') ? 'text-pink-600 after:w-full' : '' }}">
                    Album Photo
                </a>
                <a href="{{ route('order.create') }}"
                    class="bg-gradient-to-r from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Commander
                </a>
            </nav>

            {{-- Bouton menu hamburger mobile --}}
            <button type="button" id="mobile-menu-button"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 hover:text-pink-600 hover:bg-pink-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500"
                aria-expanded="false" aria-controls="mobile-menu">
                <span class="sr-only">Ouvrir le menu</span>
                {{-- Icone hamburger --}}
                <svg id="hamburger-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                {{-- Icone fermer --}}
                <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Menu mobile inline (version simple) --}}
        @include('partials.mobile-menu')
    </div>
</header>
