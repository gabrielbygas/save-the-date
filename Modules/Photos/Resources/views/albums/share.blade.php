@extends('photos::layouts.app')

@section('title', 'Partager album - Albums Photo')

@section('content')
<style>
    .share-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .share-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .share-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .share-header p {
        color: #666;
        font-size: 15px;
    }
    
    .share-method {
        margin-bottom: 32px;
        padding-bottom: 32px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .share-method:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .method-title {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .method-description {
        color: #666;
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
    }
    
    .share-box {
        background: #f0ebff;
        border: 2px dashed #d8c9ff;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    
    .share-content {
        flex: 1;
        word-break: break-all;
        font-size: 13px;
        color: #1a1a1a;
        font-family: 'Courier New', monospace;
    }
    
    .btn-copy {
        padding: 10px 16px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    
    .btn-copy:hover {
        background: #d81b60;
    }
    
    .btn-copy.copied {
        background: #059669;
    }
    
    .qr-section {
        text-align: center;
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #f0f0f0;
    }
    
    .qr-code {
        width: 200px;
        height: 200px;
        border-radius: 12px;
        border: 2px solid #f0f0f0;
        padding: 8px;
        margin: 16px auto;
        background: white;
    }
    
    .qr-label {
        font-size: 13px;
        color: #666;
        font-weight: 500;
    }
    
    .btn-primary {
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
    
    .btn-primary:hover {
        background: #d81b60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    @media (max-width: 600px) {
        .share-container { padding: 30px 20px; }
        .share-box { flex-direction: column; }
        .btn-copy { width: 100%; }
    }
</style>

<div class="share-container">
    <div class="share-header">
        <h1>🔗 Partager l'album</h1>
        <p>{{ $album->album_title }}</p>
    </div>
    
    <div class="share-method">
        <div class="method-title">📲 QR Code</div>
        <div class="method-description">Scannez le QR code pour accéder directement à l'album</div>
        @if($album->qr_code_path)
            <div class="qr-section">
                <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code" class="qr-code">
                <div class="qr-label">QR Code</div>
            </div>
        @endif
    </div>
    
    <div class="share-method">
        <div class="method-title">🔗 Lien direct</div>
        <div class="method-description">Partagez ce lien pour que vos invités accèdent à l'album</div>
        <div class="share-box">
            <div class="share-content">{{ $shareUrl }}</div>
            <button type="button" class="btn-copy" onclick="copyToClipboard(this, '{{ $shareUrl }}')">Copier</button>
        </div>
    </div>
    
    <div class="share-method">
        <div class="method-title">📧 Email</div>
        <div class="method-description">Invitez vos invités à télécharger leurs photos</div>
        <a href="{{ route('upload-tokens.create', $album->slug) }}" class="btn-primary">📧 Envoyer invitations</a>
    </div>
</div>

<script>
    function copyToClipboard(btn, text) {
        navigator.clipboard.writeText(text).then(() => {
            const original = btn.textContent;
            btn.textContent = '✓ Copié!';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.textContent = original;
                btn.classList.remove('copied');
            }, 2000);
        });
    }
</script>
@endsection
