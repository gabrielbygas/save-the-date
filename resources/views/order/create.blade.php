@extends('layouts.app')

@section('title', 'Créer une commande')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg p-5">
            <h2 class="fw-bold mb-5 text-center">Créez votre commande 💍</h2>
            
            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                <!-- Couple Information -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">👰 Informations du couple</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prénom (Monsieur) *</label>
                            <input type="text" class="form-control @error('mr_first_name') is-invalid @enderror" 
                                   name="mr_first_name" value="{{ old('mr_first_name') }}" required>
                            @error('mr_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom (Monsieur) *</label>
                            <input type="text" class="form-control @error('mr_last_name') is-invalid @enderror" 
                                   name="mr_last_name" value="{{ old('mr_last_name') }}" required>
                            @error('mr_last_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom (Madame) *</label>
                            <input type="text" class="form-control @error('mrs_first_name') is-invalid @enderror" 
                                   name="mrs_first_name" value="{{ old('mrs_first_name') }}" required>
                            @error('mrs_first_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom (Madame) *</label>
                            <input type="text" class="form-control @error('mrs_last_name') is-invalid @enderror" 
                                   name="mrs_last_name" value="{{ old('mrs_last_name') }}" required>
                            @error('mrs_last_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">📧 Contact</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}">
                        </div>
                    </div>
                </div>
                
                <!-- Wedding Details -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">💒 Détails du mariage</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Date du mariage *</label>
                            <input type="date" class="form-control @error('wedding_date') is-invalid @enderror" 
                                   name="wedding_date" value="{{ old('wedding_date') }}" required>
                            @error('wedding_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lieu *</label>
                            <input type="text" class="form-control @error('wedding_location') is-invalid @enderror" 
                                   name="wedding_location" value="{{ old('wedding_location') }}" required>
                            @error('wedding_location')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                
                <!-- Package Selection -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">📦 Pack</h5>
                    <div class="row g-3">
                        @foreach($packs as $pack)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="pack_id" 
                                           value="{{ $pack->id }}" id="pack{{ $pack->id }}" 
                                           @if(old('pack_id') == $pack->id) checked @endif required>
                                    <label class="form-check-label d-block p-3 border rounded" for="pack{{ $pack->id }}">
                                        <strong>{{ $pack->name }}</strong>
                                        <p class="small text-muted mb-0">{{ $pack->description }}</p>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Theme Selection -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">🎨 Thème</h5>
                    <select class="form-select @error('theme_id') is-invalid @enderror" name="theme_id">
                        <option value="">Sélectionnez un thème</option>
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}" @if(old('theme_id') == $theme->id) selected @endif>
                                {{ $theme->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('theme_id')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
                
                <!-- File Upload -->
                <div class="mb-5">
                    <h5 class="fw-bold mb-4">📸 Fichiers (max 5)</h5>
                    <input type="file" class="form-control @error('photos') is-invalid @enderror" 
                           name="photos[]" multiple accept="image/*,video/*">
                    <small class="text-muted d-block mt-2">Formats: JPG, PNG, MP4, MOV</small>
                    @error('photos')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                </div>
                
                <!-- Terms -->
                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" 
                               name="terms" id="terms" @if(old('terms')) checked @endif required>
                        <label class="form-check-label" for="terms">
                            J'accepte les <a href="{{ route('terms') }}" target="_blank">conditions d'utilisation</a>
                        </label>
                        @error('terms')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg w-100">Valider ma commande</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
</script>
@endsection
