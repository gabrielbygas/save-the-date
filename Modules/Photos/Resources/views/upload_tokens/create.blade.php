@extends('photos::layouts.app')

@section('title', 'Inviter des invités - Albums Photo')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .form-header {
        padding: 40px;
        text-align: center;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .form-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .form-header p {
        color: #666;
        font-size: 15px;
    }
    
    .form-section {
        padding: 40px;
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
    input[type="number"],
    input[type="date"],
    textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 16px;
        font-family: inherit;
        transition: all 0.2s ease;
        background: #fafafa;
    }
    
    input:focus,
    textarea:focus {
        outline: none;
        background: white;
        border-color: #ec407a;
        box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1);
    }
    
    .info-box {
        background: #f0ebff;
        border: 1px solid #d8c9ff;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 24px;
        font-size: 14px;
        color: #1a1a1a;
        line-height: 1.6;
    }
    
    .info-box strong {
        color: #ec407a;
    }
    
    .submit-btn {
        width: 100%;
        padding: 14px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 32px;
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
    
    .divider {
        height: 1px;
        background: #f0f0f0;
        margin: 32px 0;
    }
    
    .section-title {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        margin-top: 24px;
    }
    
    .section-title:first-of-type {
        margin-top: 0;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1>📧 Inviter des invités</h1>
        <p>{{ $album->album_title }}</p>
    </div>
    
    <form class="form-section" action="{{ route('upload-tokens.store', $album->slug) }}" method="POST" novalidate>
        @csrf
        
        <div class="info-box">
            💡 Créez des liens d'invitation uniques pour que vos invités téléchargent leurs photos. Chaque invité reçoit un lien personnel et temporaire.
        </div>
        
        <div class="section-title">Invité</div>
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <div class="divider"></div>
        
        <div class="section-title">Permissions</div>
        <div class="form-group">
            <label for="max_uses">Nombre de téléchargements autorisés *</label>
            <input type="number" id="max_uses" name="max_uses" value="{{ old('max_uses', 1) }}" min="1" max="100" required>
            @error('max_uses')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <div class="form-group">
            <label for="expires_at">Lien expire le *</label>
            <input type="date" id="expires_at" name="expires_at" value="{{ old('expires_at') }}" required>
            @error('expires_at')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <button type="submit" class="submit-btn">🔗 Créer lien d'invitation</button>
    </form>
</div>
@endsection
