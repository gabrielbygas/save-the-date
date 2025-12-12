{{-- modify by claude --}}
{{-- Footer module Photos - Composant reutilisable --}}
{{-- Inclut: 3 colonnes (Logo, Navigation, Infos), Copyright, Liens CGU --}}

<footer class="bg-gray-900 text-white mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section principale - 3 colonnes --}}
        <div class="py-10 sm:py-12 grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            {{-- Colonne 1: Logo et description --}}
            <div class="md:col-span-1">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/savethedate.webp') }}" alt="Logo" class="h-10 brightness-0 invert opacity-80">
                    <div>
                        <span class="text-lg font-bold text-white">Save The Date</span>
                        <span class="block text-xs text-pink-400 font-medium">Module Photos</span>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Partagez et collectez les plus beaux moments de votre mariage avec vos invites.
                </p>
            </div>

            {{-- Colonne 2: Liens de navigation --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Navigation</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('photos.home') }}" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm">
                            Accueil Photos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('albums.create') }}" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm">
                            Creer un album
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm">
                            Affiches & Videos
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Colonne 3: Liens legaux et contact --}}
            <div>
                <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Informations</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('photos.terms') }}" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm">
                            Conditions d'utilisation
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('photos.terms') }}" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm">
                            Politique de confidentialite
                        </a>
                    </li>
                    <li>
                        <a href="mailto:contact@savethedate.cd" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                            contact@savethedate.cd
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Copyright et liens CGU --}}
        <div class="border-t border-gray-800 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} <span class="text-pink-400">Save The Date</span>. Tous droits reserves.
                </p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('photos.terms') }}" class="text-sm text-gray-500 hover:text-pink-400 transition-colors duration-200">
                        CGU
                    </a>
                    <a href="{{ route('photos.terms') }}" class="text-sm text-gray-500 hover:text-pink-400 transition-colors duration-200">
                        Confidentialite
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
