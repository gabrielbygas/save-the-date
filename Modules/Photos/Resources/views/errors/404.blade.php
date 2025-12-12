@extends('photos::layouts.app')

@section('content')
<div style="max-width: 600px; margin: 80px auto; text-align: center; padding: 20px;">
    <div style="font-size: 64px; margin-bottom: 24px;">🔍</div>
    <h1 style="font-size: 48px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">404</h1>
    <h2 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">Page non trouvée</h2>
    <p style="font-size: 15px; color: #666; margin-bottom: 24px;">La page que vous recherchez n'existe pas ou a été supprimée.</p>
    
    <a href="{{ route('photos.home') }}" style="display: inline-block; background: #7c3aed; color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
        ← Retour à l'accueil
    </a>
</div>
@endsection
