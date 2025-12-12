@extends('photos::layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">{{ $album->album_title }}</h1>
        <p style="font-size: 15px; color: #666; margin-bottom: 4px;">Mariage de {{ ucfirst($album->client->mr_first_name) }} 💍 {{ ucfirst($album->client->mrs_first_name) }}</p>
        <p style="font-size: 13px; color: #999;">📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }} • 📷 Détail d'une photo</p>
    </div>

    <!-- Photo Card -->
    <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <img src="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" alt="Photo" style="width: 100%; max-height: 500px; object-fit: contain; border-radius: 12px; margin-bottom: 20px;">
        
        <div style="background: #f9fafb; padding: 16px; border-radius: 8px; text-align: left; font-size: 13px; color: #666; margin-bottom: 20px;">
            <p style="margin: 8px 0;"><strong style="color: #1a1a1a;">Fichier :</strong> {{ $photo->file_name }}</p>
            <p style="margin: 8px 0;"><strong style="color: #1a1a1a;">Taille :</strong> {{ number_format($photo->size_bytes / 1024, 2) }} KB</p>
            <p style="margin: 8px 0;"><strong style="color: #1a1a1a;">Ajoutée :</strong> {{ $photo->created_at->format('d-m-Y') }}</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; flex-direction: column; gap: 12px;">
        <a href="{{ route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}" style="display: block; text-align: center; background: white; border: 2px solid #e9d5ff; color: #7c3aed; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.2s;">
            ← Retour à la galerie
        </a>
        <a href="{{ route('photos.serve.photo', [$album->slug, $photo->file_name]) }}" download="{{ $photo->file_name }}" style="display: block; text-align: center; background: #7c3aed; color: white; padding: 12px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: background 0.2s;">
            📥 Télécharger
        </a>
        <form action="{{ route('photos.destroy', [$album->slug, $photo->id, 'owner_token' => $album->owner_token]) }}" method="POST" onsubmit="return confirm('Supprimer cette photo ?');" style="margin: 0;">
            @csrf
            @method('DELETE')
            <button type="submit" style="width: 100%; background: #fee2e2; color: #dc2626; padding: 12px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">
                🗑️ Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
