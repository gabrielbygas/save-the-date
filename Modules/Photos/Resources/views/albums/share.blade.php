@extends('photos::layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #7c3aed; margin-bottom: 8px;">{{ $album->album_title }}</h1>
        <p style="font-size: 16px; color: #1a1a1a; margin-bottom: 8px;">Mariage de {{ ucfirst($client->mr_first_name) }} 💍 {{ ucfirst($client->mrs_first_name) }}</p>
        <p style="font-size: 14px; color: #666;">📅 Mariage prévu le {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
    </div>

    <div style="border-top: 1px solid #e9d5ff; margin: 32px 0;"></div>

    <!-- Form -->
    <div style="background: white; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <h2 style="font-size: 20px; font-weight: 600; color: #1a1a1a; text-align: center; margin-bottom: 8px;">Partagez vos souvenirs</h2>
        <p style="text-align: center; color: #666; font-size: 14px; margin-bottom: 32px;">Pour ajouter vos photos, remplissez le formulaire ci-dessous</p>

        <!-- Messages -->
        @if (session('success'))
            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('albums.request_upload_token', $album->slug) }}" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #1a1a1a; margin-bottom: 8px;">Votre nom *</label>
                <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" placeholder="John Doe" required
                    style="width: 100%; padding: 12px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 16px; font-family: inherit; background: #fafafa; transition: all 0.2s ease;">
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #1a1a1a; margin-bottom: 8px;">Email *</label>
                <input type="email" name="visitor_email" value="{{ old('visitor_email') }}" placeholder="exemple@domaine.com" required
                    style="width: 100%; padding: 12px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 16px; font-family: inherit; background: #fafafa; transition: all 0.2s ease;">
            </div>

            <div>
                <label style="display: block; font-size: 14px; font-weight: 500; color: #1a1a1a; margin-bottom: 8px;">Téléphone WhatsApp *</label>
                <input type="text" name="visitor_phone" value="{{ old('visitor_phone') }}" placeholder="+243xxxxxxxxx" required
                    style="width: 100%; padding: 12px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 16px; font-family: inherit; background: #fafafa; transition: all 0.2s ease;">
            </div>

            <div style="margin-top: 8px;">
                <label style="display: flex; gap: 8px; font-size: 13px; color: #666;">
                    <input type="checkbox" required style="margin-top: 2px; cursor: pointer;">
                    En soumettant ce formulaire, vous acceptez les <a href="{{ route('terms') }}" target="_blank" style="color: #7c3aed; text-decoration: none; font-weight: 500;">Conditions Générales</a>
                </label>
            </div>

            <button type="submit" style="background: #7c3aed; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s ease; margin-top: 8px;">
                Recevoir le lien d'upload
            </button>
        </form>
    </div>
</div>
@endsection
