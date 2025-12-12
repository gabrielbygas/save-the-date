@extends('photos::layouts.app')

@section('title', 'Mes albums - Albums Photo')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }
    
    .page-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
    }
    
    .btn-primary {
        padding: 12px 24px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background: #d81b60;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .albums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .album-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .album-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }
    
    .album-header {
        background: linear-gradient(135deg, #ec407a 0%, #d81b60 100%);
        padding: 24px;
        color: white;
        min-height: 100px;
        display: flex;
        align-items: flex-end;
    }
    
    .album-title {
        font-size: 20px;
        font-weight: 600;
        line-height: 1.3;
    }
    
    .album-body {
        padding: 24px;
    }
    
    .album-info {
        display: grid;
        gap: 12px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #666;
    }
    
    .info-label {
        font-weight: 500;
        color: #1a1a1a;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-active {
        background: #d1fae5;
        color: #059669;
    }
    
    .status-draft {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-archived {
        background: #f3f4f6;
        color: #6b7280;
    }
    
    .album-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }
    
    .btn-small {
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        text-align: center;
    }
    
    .btn-view {
        background: #f0ebff;
        color: #ec407a;
        border: 1px solid #ddd;
    }
    
    .btn-view:hover {
        background: #ec407a;
        color: white;
        border-color: #ec407a;
    }
    
    .btn-edit {
        background: #fafafa;
        color: #1a1a1a;
        border: 1px solid #ddd;
    }
    
    .btn-edit:hover {
        background: #f0f0f0;
        border-color: #1a1a1a;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-icon {
        font-size: 64px;
        margin-bottom: 20px;
    }
    
    .empty-state h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 12px;
    }
    
    .empty-state p {
        color: #666;
        font-size: 16px;
        margin-bottom: 24px;
    }
    
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
        
        .albums-grid {
            grid-template-columns: 1fr;
        }
        
        .album-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1>📸 Mes albums</h1>
    <a href="{{ route('albums.create') }}" class="btn-primary">+ Nouvel album</a>
</div>

@if($albums->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">📋</div>
        <h2>Aucun album créé</h2>
        <p>Créez votre premier album pour partager vos photos de mariage</p>
        <a href="{{ route('albums.create') }}" class="btn-primary">Créer un album</a>
    </div>
@else
    <div class="albums-grid">
        @foreach($albums as $album)
            <div class="album-card">
                <div class="album-header">
                    <div class="album-title">{{ $album->album_title }}</div>
                </div>
                
                <div class="album-body">
                    <div class="album-info">
                        <div class="info-item">
                            <span class="info-label">📅 Mariage:</span>
                            <span>{{ \Carbon\Carbon::parse($album->wedding_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">📸 Photos:</span>
                            <span>{{ $album->photos_count ?? 0 }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="status-badge status-{{ $album->status }}">{{ $album->status }}</span>
                        </div>
                        @if($album->storage_until_at)
                        <div class="info-item">
                            <span class="info-label">⏰ Expires:</span>
                            <span>{{ \Carbon\Carbon::parse($album->storage_until_at)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="album-actions">
                        <a href="{{ route('albums.show', $album->slug) }}" class="btn-small btn-view">Voir</a>
                        <a href="{{ route('albums.edit', $album->slug) }}" class="btn-small btn-edit">Éditer</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
