@extends('photos::layouts.app')

@section('title', 'Albums Photo - Save The Date')

@section('content')
<style>
    .hero {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .hero h1 {
        font-size: 48px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 16px;
        line-height: 1.2;
    }
    
    .hero p {
        font-size: 18px;
        color: #666;
        margin-bottom: 32px;
        line-height: 1.5;
    }
    
    .hero-buttons {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-primary {
        background: #e91e63;
        color: white;
    }
    
    .btn-primary:hover {
        background: #c2185b;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(233, 30, 99, 0.3);
    }
    
    .btn-secondary {
        background: white;
        color: #e91e63;
        border: 1px solid #f0f0f0;
    }
    
    .btn-secondary:hover {
        background: #fafafa;
        border-color: #e91e63;
    }
    
    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
    }
    
    .feature-card {
        background: white;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        text-align: center;
    }
    
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }
    
    .feature-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }
    
    .feature-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .feature-card p {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .hero h1 { font-size: 32px; }
        .hero p { font-size: 16px; }
        .hero-buttons { flex-direction: column; }
    }
</style>

<div class="hero">
    <h1>📸 Partagez vos souvenirs de mariage</h1>
    <p>Créez un album privé pour vos invités avec un QR code</p>
    <div class="hero-buttons">
        <a href="{{ route('albums.login') }}" class="btn btn-primary">Se connecter</a>
        <a href="{{ route('albums.create') }}" class="btn btn-secondary">Créer un album</a>
    </div>
</div>

<div class="features">
    <div class="feature-card">
        <div class="feature-icon">🔒</div>
        <h3>Sécurisé</h3>
        <p>Album privé avec accès par QR code</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">📱</div>
        <h3>Facile</h3>
        <p>Aucune inscription requise pour vos invités</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">👥</div>
        <h3>Invités</h3>
        <p>Jusqu'à 300 invités</p>
    </div>
    <div class="feature-card">
        <div class="feature-icon">⚡</div>
        <h3>Rapide</h3>
        <p>Upload instantané en haute qualité</p>
    </div>
</div>
@endsection
