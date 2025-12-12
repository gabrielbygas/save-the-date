@extends('photos::layouts.app')

@section('title', 'Créer un album - Albums Photo')

@section('content')
    <style>
        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .form-header {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #666;
            font-size: 16px;
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
            .form-row {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 30px 20px;
            }

            .form-header {
                padding: 30px 20px;
            }
        }

        .section-title {
            font-size: 14px;
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

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="number"],
        select {
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
        select:focus {
            outline: none;
            background: white;
            border-color: #ec407a;
            box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #ec407a;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
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
    </style>

    <div class="form-container">
        <div class="form-header">
            <h1>📸 Créer un album</h1>
            <p>Partagez vos photos de mariage avec vos invités</p>
        </div>

        <form class="form-section" action="{{ route('albums.store') }}" method="POST" novalidate>
            @csrf

            <div class="section-title">Couple</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="mr_first_name">Prénom (M) *</label>
                    <input type="text" id="mr_first_name" name="mr_first_name" value="{{ old('mr_first_name') }}"
                        required>
                    @error('mr_first_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mr_last_name">Nom (M) *</label>
                    <input type="text" id="mr_last_name" name="mr_last_name" value="{{ old('mr_last_name') }}" required>
                    @error('mr_last_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mrs_first_name">Prénom (Mme) *</label>
                    <input type="text" id="mrs_first_name" name="mrs_first_name" value="{{ old('mrs_first_name') }}"
                        required>
                    @error('mrs_first_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mrs_last_name">Nom (Mme) *</label>
                    <input type="text" id="mrs_last_name" name="mrs_last_name" value="{{ old('mrs_last_name') }}"
                        required>
                    @error('mrs_last_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="section-title">Contact</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone *</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-title">Album</div>
            <div class="form-group">
                <label for="album_title">Titre de l'album *</label>
                <input type="text" id="album_title" name="album_title" value="{{ old('album_title') }}" required>
                @error('album_title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="wedding_date">Date du mariage *</label>
                    <input type="date" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}" required>
                    @error('wedding_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="max_guests">Nombre d'invités max</label>
                    <input type="number" id="max_guests" name="max_guests" value="{{ old('max_guests') }}" min="1"
                        max="1000">
                </div>
            </div>

            <button type="submit" class="submit-btn">Créer mon album</button>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', e => {
            const form = e.target;
            if (!form.checkValidity()) {
                e.preventDefault();
                form.querySelectorAll('input:invalid, select:invalid').forEach(field => {
                    field.closest('.form-group')?.classList.add('error');
                });
            }
        });
    </script>
@endsection
