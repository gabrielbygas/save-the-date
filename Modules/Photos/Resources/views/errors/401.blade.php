@extends('photos::layouts.app')

@section('content')
<div style="max-width: 600px; margin: 80px auto; text-align: center; padding: 20px;">
    <div style="font-size: 64px; margin-bottom: 24px;">🔐</div>
    <h1 style="font-size: 48px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">401</h1>
    <h2 style="font-size: 20px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">Non authentifié</h2>
    <p style="font-size: 15px; color: #666; margin-bottom: 24px;">Veuillez vous connecter pour accéder à cette page.</p>
    
    <a href="{{ route('albums.login') }}" style="display: inline-block; background: #7c3aed; color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background 0.2s;">
        Se connecter
    </a>
</div>
@endsection
