@extends('photos::layouts.app')

@section('title', 'Non authentifié - Albums Photo')

@section('content')
<style>
    .error-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        padding: 60px 20px;
    }
    
    .error-icon {
        font-size: 80px;
        margin-bottom: 24px;
    }
    
    .error-code {
        font-size: 48px;
        font-weight: 700;
        color: #ec407a;
        margin-bottom: 12px;
    }
    
    .error-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }
    
    .error-message {
        font-size: 16px;
        color: #666;
        margin-bottom: 32px;
        line-height: 1.5;
    }
    
    .btn-home {
        display: inline-block;
        padding: 14px 32px;
        background: #ec407a;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    
    .btn-home:hover {
        background: #d81b60;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
</style>

<div class="error-container">
    <div class="error-icon">🔑</div>
    <div class="error-code">401</div>
    <h1 class="error-title">Authentification requise</h1>
    <p class="error-message">Veuillez vous authentifier pour accéder à cette ressource. Si vous n'avez pas de compte, créez-en un.</p>
    <a href="{{ route('albums.login') }}" class="btn-home">← Se connecter</a>
</div>
@endsection
