@extends('photos::layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 8px;">{{ $album->album_title }}</h1>
        <p style="color: #666; font-size: 16px;">Mariage de {{ ucfirst($client->mr_first_name) }} 💍 {{ ucfirst($client->mrs_first_name) }}</p>
    </div>

    <!-- Album Info Card -->
    <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px; color: #666; margin-bottom: 16px;">
            <span>📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</span>
            <span>👥 {{ $album->max_guests }} invités</span>
        </div>
        <div style="display: inline-block; background: #f3e8ff; color: #7c3aed; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 500;">
            Statut: <span style="font-weight: 600;">{{ ucfirst($album->status) }}</span>
        </div>
    </div>

    <!-- Messages -->
    @if (session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- QR Code & Share -->
    @if ($album->qr_code_path)
        <div style="background: white; border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <p style="color: #666; font-size: 14px; margin-bottom: 16px;">Partager avec vos invités</p>
            <img src="{{ asset('storage/' . $album->qr_code_path) }}" alt="QR Code" style="width: 160px; height: 160px; margin: 0 auto 24px;">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <button onclick="copyShareLink()" style="width: 100%; background: #7c3aed; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 500; cursor: pointer; transition: background 0.2s;">
                    🔗 Copier le lien
                </button>
                <a href="{{ asset('storage/' . $album->qr_code_path) }}" download="qrcode-{{ $album->slug }}.png" style="display: block; background: #f3f4f6; color: #1f2937; border: none; padding: 12px; border-radius: 8px; font-weight: 500; text-decoration: none; text-align: center; transition: background 0.2s;">
                    📥 Télécharger QR Code
                </a>
            </div>
            <p style="font-size: 12px; color: #999; margin-top: 16px; background: #f9fafb; padding: 12px; border-radius: 8px; font-family: monospace; word-break: break-all;" id="share-link-text">{{ route('albums.share', $album->share_url_token) }}</p>
        </div>
    @endif

    <!-- Action Buttons -->
    <div style="display: flex; flex-direction: column; gap: 12px;">
        <a href="{{ route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}" style="display: block; text-align: center; background: white; border: 2px solid #e9d5ff; color: #7c3aed; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.2s;">
            ← Voir les photos
        </a>
        <a href="{{ route('photos.create', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}" style="display: block; text-align: center; background: #7c3aed; color: white; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.2s;">
            📷 Ajouter des photos
        </a>
    </div>
</div>

<script>
    function copyShareLink() {
        const el = document.getElementById('share-link-text');
        const text = el.textContent.trim();
        navigator.clipboard.writeText(text).then(() => {
            const btn = event.target;
            const original = btn.textContent;
            btn.textContent = '✓ Copié!';
            setTimeout(() => btn.textContent = original, 2000);
        });
    }
</script>
@endsection
