@extends('photos::layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Photos de l'album : {{ $album->album_title }}</h1>
        <p style="font-size: 15px; color: #666; margin-bottom: 4px;">Mariage de {{ ucfirst($client->mr_first_name) }} 💍 {{ ucfirst($client->mrs_first_name) }}</p>
        <p style="font-size: 13px; color: #999;">📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }} • 📷 {{ $photos->count() }} photo(s)</p>
    </div>

    <!-- Messages -->
    @if (session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Upload Action -->
    @if (!$uploadToken->used)
        <div style="margin-bottom: 32px;">
            <a href="{{ route('photos.invite.upload', [$album->slug, $uploadToken->token]) }}" style="display: inline-block; background: #7c3aed; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                📷 Ajouter des photos
            </a>
        </div>
    @else
        <div style="background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 32px; font-size: 14px;">
            Vous avez atteint la limite de 5 photos autorisées.
        </div>
    @endif

    <!-- Gallery -->
    @if ($photos->isEmpty())
        <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 16px; color: #999;">
            Aucune photo dans cet album.
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; grid-auto-rows: 180px;">
            @foreach ($photos as $photo)
                <div style="position: relative; border-radius: 12px; overflow: hidden; background: #f3f4f6; group; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <img src="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" alt="{{ $photo->caption ?? 'Photo' }}" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <!-- Overlay Actions -->
                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; gap: 10px; opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                        <a href="{{ route('photos.invite.show', [$album->slug, $photo->id, $uploadToken->token]) }}" style="width: 36px; height: 36px; background: white; color: #7c3aed; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; transition: all 0.2s;">
                            👁️
                        </a>
                        <a href="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" download="{{ $photo->file_name }}" style="width: 36px; height: 36px; background: white; color: #7c3aed; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; transition: all 0.2s;">
                            ⬇️
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
