<!-- Modules/Photos/Resources/views/albums/index.blade.php -->
@extends('photos::layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
        <h1 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin: 0;">
            Albums de {{ ucfirst($client->mr_first_name) }} et {{ ucfirst($client->mrs_first_name) }}
        </h1>
        <a href="{{ route('albums.login') }}" style="background: #7c3aed; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            Déconnexion
        </a>
    </div>

    @if (session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
        @forelse ($albums as $album)
            <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: all 0.2s ease;">
                <h2 style="font-size: 18px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px;">{{ $album->album_title }}</h2>
                <p style="color: #666; font-size: 14px; margin-bottom: 8px;">
                    📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}
                </p>
                <p style="color: #999; font-size: 13px; margin-bottom: 16px;">
                    👥 {{ $album->uploadTokens()->count() }} invité(s) • 📷 {{ $album->photos()->count() }} photo(s)
                </p>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('albums.show', $album->slug) }}" style="flex: 1; text-align: center; background: #7c3aed; color: white; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.2s;">
                        Voir l'album
                    </a>
                    <a href="{{ route('albums.share', $album->share_url_token) }}" style="flex: 1; text-align: center; background: #f3e8ff; color: #7c3aed; padding: 10px 12px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 500; transition: background 0.2s;">
                        Partager
                    </a>
                </div>
            </div>
        @empty
            <p style="color: #999; text-align: center; grid-column: 1 / -1; padding: 40px 20px;">
                Aucun album trouvé. <a href="{{ route('albums.create') }}" style="color: #7c3aed; text-decoration: none; font-weight: 500;">Créer un album</a>
            </p>
        @endforelse
    </div>
</div>
@endsection
