{{-- modify by claude --}}
{{-- Header module Photos - Composant reutilisable --}}
{{-- Inclut: Logo, navigation, menu hamburger, effet sticky avec backdrop-blur --}}

<header id="main-header" class="bg-white/80 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-18">
            {{-- Logo Save The Date + Photos --}}
            <a href="{{ route('photos.home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/savethedate.webp') }}" alt="Logo Save The Date"
                    class="h-10 sm:h-12 transition-transform duration-300 group-hover:scale-105">
                <div class="hidden sm:block">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-lg font-bold bg-gradient-to-r from-pink-600 to-rose-500 bg-clip-text text-transparent">
                            Save The Date
                        </span>
                        <span class="text-xs font-semibold text-pink-400 bg-pink-50 px-2 py-0.5 rounded-full">
                            Photos
                        </span>
                    </div>
                    <span class="text-xs text-gray-400 font-medium">Album collaboratif</span>
                </div>
            </a>

            {{-- Navigation desktop claire --}}
            <nav class="hidden md:flex items-center gap-1">
                @if (session()->has('client_id'))
                    <a href="{{ route('albums.index') }}"
                        class="nav-link px-4 py-2 text-gray-600 hover:text-pink-600 font-medium text-sm transition-colors duration-200 rounded-lg hover:bg-pink-50/50 {{ request()->routeIs('albums.index') ? 'active' : '' }}">
                        Mes Albums
                    </a>
                @endif
                <a href="{{ route('albums.create') }}"
                    class="nav-link px-4 py-2 text-gray-600 hover:text-pink-600 font-medium text-sm transition-colors duration-200 rounded-lg hover:bg-pink-50/50 {{ request()->routeIs('albums.create') ? 'active' : '' }}">
                    Creer un Album
                </a>
                <a href="{{ route('photos.terms') }}"
                    class="nav-link px-4 py-2 text-gray-600 hover:text-pink-600 font-medium text-sm transition-colors duration-200 rounded-lg hover:bg-pink-50/50 {{ request()->routeIs('photos.terms') ? 'active' : '' }}">
                    Aide
                </a>

                {{-- Separateur et boutons d'action --}}
                <div class="h-6 w-px bg-gray-200 mx-3"></div>

                @if (session()->has('client_id'))
                    <form action="{{ route('albums.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 text-gray-500 hover:text-red-600 font-medium text-sm transition-all duration-200 rounded-lg hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Deconnexion</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('albums.create') }}"
                        class="btn-primary text-white px-5 py-2.5 rounded-xl font-medium text-sm shadow-lg shadow-pink-500/20">
                        Commencer
                    </a>
                @endif
            </nav>

            {{-- Bouton menu hamburger mobile --}}
            <button type="button" id="mobile-menu-btn"
                class="md:hidden relative w-10 h-10 flex items-center justify-center rounded-xl text-gray-600 hover:text-pink-600 hover:bg-pink-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-pink-500/20"
                aria-expanded="false" aria-label="Menu principal">
                <svg id="icon-menu" class="w-6 h-6 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="icon-close" class="w-6 h-6 absolute opacity-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</header>
