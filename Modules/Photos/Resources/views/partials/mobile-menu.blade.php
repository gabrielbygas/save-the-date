{{-- modify by claude --}}
{{-- Menu mobile module Photos - Composant reutilisable --}}
{{-- Inclut: Panel coulissant, overlay, navigation complete, fermeture --}}

{{-- Menu mobile overlay --}}
<div id="mobile-overlay" class="mobile-menu-overlay fixed inset-0 bg-black/20 backdrop-blur-sm md:hidden z-40"></div>

{{-- Menu mobile panel --}}
<div id="mobile-panel" class="mobile-menu-panel fixed top-0 right-0 h-full w-72 max-w-[85vw] bg-white shadow-2xl md:hidden z-50">
    <div class="flex flex-col h-full">
        {{-- Header du menu mobile --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/savethedate.webp') }}" alt="Logo" class="h-8">
                <span class="font-semibold text-gray-800">Menu</span>
            </div>
            <button id="close-mobile-menu" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation mobile --}}
        <nav class="flex-1 overflow-y-auto p-4">
            <ul class="space-y-1">
                @if (session()->has('client_id'))
                    <li>
                        <a href="{{ route('albums.index') }}"
                            class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('albums.index') ? 'text-pink-600 bg-pink-50' : '' }}">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <span>Mes Albums</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ route('albums.create') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('albums.create') ? 'text-pink-600 bg-pink-50' : '' }}">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Creer un Album</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('photos.terms') }}"
                        class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:text-pink-600 hover:bg-pink-50 rounded-xl font-medium transition-all duration-200 {{ request()->routeIs('photos.terms') ? 'text-pink-600 bg-pink-50' : '' }}">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                        <span>Aide</span>
                    </a>
                </li>
            </ul>
        </nav>

        {{-- Footer du menu mobile --}}
        <div class="p-4 border-t border-gray-100">
            @if (session()->has('client_id'))
                <form action="{{ route('albums.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-medium transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        <span>Deconnexion</span>
                    </button>
                </form>
            @else
                <a href="{{ route('albums.create') }}"
                    class="block w-full text-center btn-primary text-white px-4 py-3 rounded-xl font-medium shadow-lg shadow-pink-500/20">
                    Commencer maintenant
                </a>
            @endif
        </div>
    </div>
</div>
