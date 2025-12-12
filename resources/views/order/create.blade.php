<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une commande - Save The Date</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .header {
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .header p {
            color: #666;
            font-size: 16px;
        }
        
        .form-section {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group:last-child {
            margin-bottom: 0;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
            .form-section { padding: 30px 20px; }
            .header { padding: 30px 20px; }
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
            border-color: #0a84ff;
            box-shadow: 0 0 0 3px rgba(10, 132, 255, 0.1);
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .pack-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .pack-option {
            position: relative;
        }
        
        .pack-option input {
            display: none;
        }
        
        .pack-label {
            display: block;
            padding: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        
        .pack-label strong {
            display: block;
            margin-bottom: 4px;
            color: #1a1a1a;
        }
        
        .pack-label span {
            font-size: 13px;
            color: #666;
        }
        
        .pack-option input:checked + .pack-label {
            background: #0a84ff;
            border-color: #0a84ff;
            color: white;
        }
        
        .pack-option input:checked + .pack-label strong,
        .pack-option input:checked + .pack-label span {
            color: white;
        }
        
        .file-upload {
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .file-upload:hover {
            border-color: #0a84ff;
            background: rgba(10, 132, 255, 0.05);
        }
        
        .file-upload input {
            display: none;
        }
        
        .file-upload p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            background: #fafafa;
            border-radius: 10px;
            margin-top: 24px;
        }
        
        .checkbox-group input {
            width: auto;
            min-width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
        }
        
        .checkbox-group label {
            margin: 0;
            font-size: 14px;
            cursor: pointer;
        }
        
        .checkbox-group a {
            color: #0a84ff;
            text-decoration: none;
        }
        
        .checkbox-group a:hover {
            text-decoration: underline;
        }
        
        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #0a84ff;
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
            background: #0070d2;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(10, 132, 255, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .error-message {
            color: #ff3b30;
            font-size: 13px;
            margin-top: 6px;
        }
        
        .success-message {
            color: #34c759;
            font-size: 13px;
            margin-top: 6px;
        }
        
        .form-group.error input,
        .form-group.error select {
            border-color: #ff3b30;
        }
        
        .divider {
            height: 1px;
            background: #f0f0f0;
            margin: 32px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💍 Créer une commande</h1>
            <p>Affiches & vidéos de mariage personnalisées</p>
        </div>
        
        <!-- Form -->
        <form class="form-section" action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            
            <!-- Couple Info -->
            <div class="section-title">Couple</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="mr_first_name">Prénom (M) *</label>
                    <input type="text" id="mr_first_name" name="mr_first_name" value="{{ old('mr_first_name') }}" required>
                    @error('mr_first_name')<div class="error-message">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="mr_last_name">Nom (M) *</label>
                    <input type="text" id="mr_last_name" name="mr_last_name" value="{{ old('mr_last_name') }}" required>
                    @error('mr_last_name')<div class="error-message">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="mrs_first_name">Prénom (Mme) *</label>
                    <input type="text" id="mrs_first_name" name="mrs_first_name" value="{{ old('mrs_first_name') }}" required>
                    @error('mrs_first_name')<div class="error-message">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="mrs_last_name">Nom (Mme) *</label>
                    <input type="text" id="mrs_last_name" name="mrs_last_name" value="{{ old('mrs_last_name') }}" required>
                    @error('mrs_last_name')<div class="error-message">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <!-- Contact -->
            <div class="section-title">Contact</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<div class="error-message">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                </div>
            </div>
            
            <!-- Wedding -->
            <div class="section-title">Mariage</div>
            <div class="form-row">
                <div class="form-group">
                    <label for="wedding_date">Date *</label>
                    <input type="date" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}" required>
                    @error('wedding_date')<div class="error-message">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="wedding_location">Lieu *</label>
                    <input type="text" id="wedding_location" name="wedding_location" value="{{ old('wedding_location') }}" required>
                    @error('wedding_location')<div class="error-message">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="divider"></div>
            
            <!-- Pack Selection -->
            <div class="section-title">Pack</div>
            <div class="pack-options">
                @foreach($packs as $pack)
                <div class="pack-option">
                    <input type="radio" id="pack{{ $pack->id }}" name="pack_id" value="{{ $pack->id }}" 
                           @if(old('pack_id') == $pack->id) checked @endif required>
                    <label for="pack{{ $pack->id }}" class="pack-label">
                        <strong>{{ $pack->name }}</strong>
                        <span>{{ $pack->description }}</span>
                    </label>
                </div>
                @endforeach
            </div>
            @error('pack_id')<div class="error-message">{{ $message }}</div>@enderror
            
            <!-- Theme -->
            <div class="section-title">Thème</div>
            <div class="form-group">
                <select name="theme_id">
                    <option value="">Sélectionner un thème</option>
                    @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" @if(old('theme_id') == $theme->id) selected @endif>
                        {{ $theme->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Files -->
            <div class="section-title">Fichiers</div>
            <div class="form-group">
                <div class="file-upload" onclick="document.getElementById('photos').click()">
                    <p>📸 Cliquez ou glissez vos fichiers (max 5)</p>
                    <input type="file" id="photos" name="photos[]" multiple accept="image/*,video/*">
                </div>
                <small style="display: block; margin-top: 8px; color: #666;">JPG, PNG, MP4 (max 50MB)</small>
            </div>
            
            <!-- Terms -->
            <div class="checkbox-group">
                <input type="checkbox" id="terms" name="terms" value="1" @if(old('terms')) checked @endif required>
                <label for="terms">J'accepte les <a href="{{ route('terms') }}" target="_blank">conditions d'utilisation</a></label>
            </div>
            @error('terms')<div class="error-message" style="margin-top: 8px;">{{ $message }}</div>@enderror
            
            <!-- Submit -->
            <button type="submit" class="submit-btn">Créer ma commande</button>
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
</body>
</html>
