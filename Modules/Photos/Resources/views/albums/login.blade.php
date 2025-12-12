@extends('photos::layouts.app')

@section('title', 'Se connecter - Albums Photo')

@section('content')
<style>
    .login-container {
        max-width: 450px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }
    
    .login-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .login-header p {
        color: #666;
        font-size: 15px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    input[type="email"],
    input[type="text"] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 16px;
        font-family: inherit;
        transition: all 0.2s ease;
        background: #fafafa;
    }
    
    input:focus {
        outline: none;
        background: white;
        border-color: #ec407a;
        box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1);
    }
    
    .submit-btn {
        width: 100%;
        padding: 12px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .submit-btn:hover {
        background: #d81b60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .error-message {
        color: #ff3b30;
        font-size: 13px;
        margin-top: 6px;
    }
    
    .info-text {
        text-align: center;
        color: #666;
        font-size: 13px;
        margin-top: 20px;
    }
    
    .info-text a {
        color: #ec407a;
        text-decoration: none;
    }
    
    .info-text a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-container">
    <div class="login-header">
        <h1>Se connecter</h1>
        <p>Accédez à votre album photo</p>
    </div>
    
    <form action="{{ route('albums.send_otp') }}" method="POST" novalidate>
        @csrf
        
        <div class="form-group">
            <label for="identifier">Email ou identifiant *</label>
            <input type="email" id="identifier" name="identifier" value="{{ old('identifier') }}" required autofocus>
            @error('identifier')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <button type="submit" class="submit-btn">Envoyer le code OTP</button>
    </form>
    
    <div class="info-text">
        Vous recevrez un code à 6 chiffres par email
    </div>
    
    <div class="info-text" style="margin-top: 32px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
        Pas encore d'album? <a href="{{ route('albums.create') }}">Créer un album</a>
    </div>
</div>
@endsection
