@extends('photos::layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg p-4 md:p-6 lg:p-8 text-center">
        <div class="mb-6">
            <h1 class="text-4xl md:text-5xl font-bold text-pink-600 mb-4">403</h1>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-2">Accès interdit.</h2>
            @if(isset($exception) && $exception->getMessage())
                <p class="text-gray-600 mb-4">
                    {{ $exception->getMessage() }}
                </p>
            @else
                <p class="text-gray-600 mb-4">
                    Vous n'avez pas la permission d'accéder à cette page.
                </p>
            @endif
            <a href="{{ route('photos.home') }}"
               class="px-4 py-2 bg-pink-500 text-white rounded-lg font-bold text-sm hover:bg-pink-600 transition">
                Retour à l'accueil
            </a>
        </div>
        <div class="mt-8">
            <img src="{{ asset('images/403_illustration.webp') }}" alt="Illustration 403" class="w-64 h-64 mx-auto">
        </div>
    </div>
@endsection
