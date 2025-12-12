@extends('photos::layouts.app')

@section('title', 'Éditer album - Albums Photo')

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
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
        .form-section { padding: 30px 20px; }
        .form-header { padding: 30px 20px; }
    }
    
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="date"],
    input[type="number"],
    select,
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
    select:focus,
    textarea:focus {
        outline: none;
        background: white;
        border-color: #ec407a;
        box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1);
    }
    
    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }
    
    .btn {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-submit {
        background: #ec407a;
        color: white;
    }
    
    .btn-submit:hover {
        background: #d81b60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .btn-cancel {
        background: white;
        color: #666;
        border: 1px solid #e0e0e0;
    }
    
    .btn-cancel:hover {
        background: #fafafa;
        border-color: #666;
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
        <h1>Éditer album</h1>
        <p>{{ $album->album_title }}</p>
    </div>
    
    <form class="form-section" action="{{ route('albums.update', $album->slug) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        
        <div class="section-title">Informations</div>
        <div class="form-group">
            <label for="album_title">Titre de l'album *</label>
            <input type="text" id="album_title" name="album_title" value="{{ old('album_title', $album->album_title) }}" required>
            @error('album_title')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="wedding_date">Date du mariage *</label>
                <input type="date" id="wedding_date" name="wedding_date" value="{{ old('wedding_date', $album->wedding_date) }}" required>
                @error('wedding_date')<div class="error-message">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="max_guests">Nombre d'invités max</label>
                <input type="number" id="max_guests" name="max_guests" value="{{ old('max_guests', $album->max_guests) }}" min="1" max="1000">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="opens_at">Album ouvert à partir du</label>
                <input type="date" id="opens_at" name="opens_at" value="{{ old('opens_at', $album->opens_at) }}">
            </div>
            <div class="form-group">
                <label for="storage_until_at">Photos conservées jusqu'au</label>
                <input type="date" id="storage_until_at" name="storage_until_at" value="{{ old('storage_until_at', $album->storage_until_at) }}">
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section-title">Statut</div>
        <div class="form-group">
            <label for="status">Statut de l'album *</label>
            <select name="status" id="status" required>
                <option value="draft" @if(old('status', $album->status) == 'draft') selected @endif>Brouillon</option>
                <option value="active" @if(old('status', $album->status) == 'active') selected @endif>Actif</option>
                <option value="archived" @if(old('status', $album->status) == 'archived') selected @endif>Archivé</option>
            </select>
            @error('status')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        
        <div class="btn-group">
            <button type="submit" class="btn btn-submit">💾 Enregistrer</button>
            <a href="{{ route('albums.show', $album->slug) }}" class="btn btn-cancel">Annuler</a>
        </div>
    </form>
</div>
@endsection
