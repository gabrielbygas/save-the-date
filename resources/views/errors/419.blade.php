@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-slate-100 flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="mb-8">
            <h1 class="text-8xl font-light text-slate-300 mb-4">419</h1>
            <h2 class="text-2xl font-medium text-slate-900 mb-3">Session expirée</h2>
            <p class="text-slate-600 leading-relaxed">
                @if(isset($exception) && $exception->getMessage())
                    {{ $exception->getMessage() }}
                @else
                    Votre session a expiré. Veuillez réessayer.
                @endif
            </p>
        </div>
        <a href="{{ route('home') }}" class="inline-block px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection
