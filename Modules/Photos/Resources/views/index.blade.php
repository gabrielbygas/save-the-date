@extends('photos::layouts.app')

@section('title', 'Albums Photo - Save The Date')

@section('content')
<div class="text-center mb-5">
    <h1 class="display-5 fw-bold mb-3">📸 Partagez vos souvenirs de mariage</h1>
    <p class="lead text-muted mb-4">Créez un album privé pour vos invités avec un QR code</p>
    
    <a href="{{ route('albums.login') }}" class="btn btn-primary btn-lg me-2">Se connecter</a>
    <a href="{{ route('albums.create') }}" class="btn btn-outline-primary btn-lg">Créer un album</a>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 text-center">
            <h5 class="fw-bold mb-3">🔒 Sécurisé</h5>
            <p class="small text-muted">Album privé avec accès par QR code</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 text-center">
            <h5 class="fw-bold mb-3">📱 Facile</h5>
            <p class="small text-muted">Aucune inscription requise</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 text-center">
            <h5 class="fw-bold mb-3">👥 Invités</h5>
            <p class="small text-muted">Jusqu'à 300 invités</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 text-center">
            <h5 class="fw-bold mb-3">⚡ Rapide</h5>
            <p class="small text-muted">Upload instantané</p>
        </div>
    </div>
</div>
@endsection
