@extends('photos::layouts.app')

@section('title', $album->album_title . ' - Albums Photo')

@section('content')
<style>
    .album-header {
        background: white;
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 40px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 40px;
    }
    
    .header-text h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }
    
    .header-meta {
        display: grid;
        gap: 12px;
        font-size: 15px;
        color: #666;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .qr-section {
        text-align: center;
    }
    
    .qr-code {
        width: 200px;
        height: 200px;
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 12px;
        padding: 12px;
        display: inline-block;
    }
    
    .qr-label {
        margin-top: 12px;
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }
    
    .btn-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 24px;
    }
    
    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background: #ec407a;
        color: white;
    }
    
    .btn-primary:hover {
        background: #d81b60;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .btn-secondary {
        background: white;
        color: #ec407a;
        border: 1px solid #ec407a;
    }
    
    .btn-secondary:hover {
        background: #f0ebff;
    }
    
    .photos-section {
        margin-top: 40px;
    }
    
    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 24px;
    }
    
    .photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .photo-card {
        border-radius: 12px;
        overflow: hidden;
        background: white;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .photo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }
    
    .photo-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }
    
    .photo-info {
        padding: 16px;
    }
    
    .photo-name {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .photo-date {
        font-size: 12px;
        color: #999;
    }
    
    .empty-photos {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
    }
    
    .empty-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 24px;
        }
        
        .qr-section {
            order: -1;
        }
        
        .photos-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>

<div class="album-header">
    <div class="header-content">
        <div class="header-text">
            <h1>{{ $album->album_title }}</h1>
            <div class="header-meta">
                <div class="meta-item">
                    <span>👫</span> Couple: <strong>{{ $album->client->mr_first_name }} & {{ $album->client->mrs_first_name }}</strong>
                </div>
                <div class="meta-item">
                    <span>📅</span> Mariage: <strong>{{ \Carbon\Carbon::parse($album->wedding_date)->format('d/m/Y') }}</strong>
                </div>
                <div class="meta-item">
                    <span>📸</span> Photos: <strong>{{ $album->photos_count ?? 0 }}</strong>
                </div>
            </div>
        </div>
        
        <div class="qr-section">
            @if($album->qr_code_path)
                <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code" class="qr-code">
            @endif
            <div class="qr-label">QR Code partage</div>
        </div>
    </div>
    
    <div class="btn-group">
        <a href="{{ route('albums.edit', $album->slug) }}" class="btn btn-primary">✏️ Éditer</a>
        <a href="{{ route('albums.share', $album->slug) }}" class="btn btn-secondary">🔗 Partager</a>
        <a href="{{ route('upload-tokens.create', $album->slug) }}" class="btn btn-secondary">📧 Inviter</a>
    </div>
</div>

<div class="photos-section">
    <h2 class="section-title">Photos de l'album</h2>
    
    @if($album->photos->isEmpty())
        <div class="empty-photos">
            <div class="empty-icon">📭</div>
            <h3 style="color: #1a1a1a; margin-bottom: 8px;">Aucune photo</h3>
            <p style="color: #666;">Les photos apparaîtront ici une fois ajoutées</p>
        </div>
    @else
        <div class="photos-grid">
            @foreach($album->photos as $photo)
                <div class="photo-card">
                    <img src="{{ asset('storage/' . $photo->thumb_path) }}" alt="Photo" class="photo-image">
                    <div class="photo-info">
                        <div class="photo-name">{{ basename($photo->original_path) }}</div>
                        <div class="photo-date">{{ $photo->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
