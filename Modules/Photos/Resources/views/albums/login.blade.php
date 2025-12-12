@extends('photos::layouts.app')

@section('title', 'Se connecter - Albums Photo')

@section('content')
<style>
    .login-container {
        max-width: 450px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }
    
    .login-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .login-header p {
        color: #666;
        font-size: 15px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    input[type="email"],
    input[type="text"] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 16px;
        font-family: inherit;
        transition: all 0.2s ease;
        background: #fafafa;
    }
    
    input:focus {
        outline: none;
        background: white;
        border-color: #ec407a;
        box-shadow: 0 0 0 3px rgba(236, 64, 122, 0.1);
    }
    
    .submit-btn {
        width: 100%;
        padding: 12px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .submit-btn:hover:not(:disabled) {
        background: #d81b60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .submit-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .error-message {
        color: #ff3b30;
        font-size: 13px;
        margin-top: 6px;
        padding: 12px;
        background: #fee2e2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        display: none;
    }
    
    .error-message.show {
        display: block;
    }
    
    .success-message {
        color: #059669;
        font-size: 13px;
        margin-top: 12px;
        padding: 12px;
        background: #d1fae5;
        border: 1px solid #a7f3d0;
        border-radius: 8px;
        display: none;
    }
    
    .success-message.show {
        display: block;
    }
    
    .otp-section {
        display: none;
        margin-top: 32px;
        padding-top: 32px;
        border-top: 1px solid #f0f0f0;
    }
    
    .otp-section.show {
        display: block;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .otp-title {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 16px;
    }
    
    .info-text {
        text-align: center;
        color: #666;
        font-size: 13px;
        margin-top: 20px;
    }
    
    .info-text a {
        color: #ec407a;
        text-decoration: none;
    }
    
    .info-text a:hover {
        text-decoration: underline;
    }
    
    .email-reset {
        text-align: center;
        margin-top: 16px;
    }
    
    .email-reset button {
        background: none;
        border: none;
        color: #ec407a;
        cursor: pointer;
        font-size: 13px;
        text-decoration: underline;
        padding: 0;
    }
    
    .email-reset button:hover {
        color: #d81b60;
    }
</style>

<div class="login-container">
    <div class="login-header">
        <h1>Se connecter</h1>
        <p>Accédez à votre album photo</p>
    </div>
    
    <!-- Étape 1: Email -->
    <div id="email-section">
        <form id="email-form" novalidate>
            @csrf
            <div class="form-group">
                <label for="identifier">Email *</label>
                <input type="email" id="identifier" name="identifier" required autofocus>
            </div>
            
            <div class="error-message" id="email-error"></div>
            <div class="success-message" id="email-success"></div>
            
            <button type="submit" class="submit-btn" id="email-submit">Continuer</button>
        </form>
    </div>
    
    <!-- Étape 2: OTP -->
    <div id="otp-section" class="otp-section">
        <div class="otp-title">Entrez votre code OTP</div>
        <p style="color: #666; font-size: 13px; margin-bottom: 16px;">Un code a été envoyé à <strong id="email-display"></strong></p>
        
        <form id="otp-form" novalidate>
            @csrf
            <input type="hidden" id="otp-identifier" name="identifier">
            
            <div class="form-group">
                <label for="otp">Code OTP (6 chiffres) *</label>
                <input type="text" id="otp" name="otp" maxlength="6" placeholder="000000" required>
            </div>
            
            <div class="error-message" id="otp-error"></div>
            <div class="success-message" id="otp-success"></div>
            
            <button type="submit" class="submit-btn" id="otp-submit">Se connecter</button>
        </form>
        
        <div class="email-reset">
            <button type="button" id="back-to-email">Changer d'email</button>
        </div>
    </div>
    
    <div class="info-text" style="margin-top: 32px; padding-top: 20px; border-top: 1px solid #f0f0f0;">
        Pas encore d'album? <a href="{{ route('albums.create') }}">Créer un album</a>
    </div>
</div>

<script>
    const emailForm = document.getElementById('email-form');
    const otpForm = document.getElementById('otp-form');
    const emailSection = document.getElementById('email-section');
    const otpSection = document.getElementById('otp-section');
    const emailError = document.getElementById('email-error');
    const otpError = document.getElementById('otp-error');
    const emailSuccess = document.getElementById('email-success');
    const otpSuccess = document.getElementById('otp-success');
    const backBtn = document.getElementById('back-to-email');
    const emailDisplay = document.getElementById('email-display');
    const otpIdentifier = document.getElementById('otp-identifier');
    
    // Étape 1: Soumettre l'email
    emailForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const identifier = document.getElementById('identifier').value;
        const btn = document.getElementById('email-submit');
        
        emailError.classList.remove('show');
        emailError.textContent = '';
        btn.disabled = true;
        btn.textContent = 'Vérification...';
        
        try {
            const response = await fetch('{{ route("albums.send_otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ identifier })
            });
            
            const data = await response.json();
            
            if (data.success) {
                emailSuccess.textContent = data.message;
                emailSuccess.classList.add('show');
                
                // Afficher la section OTP
                setTimeout(() => {
                    emailSection.style.display = 'none';
                    otpSection.classList.add('show');
                    emailDisplay.textContent = identifier;
                    otpIdentifier.value = identifier;
                    document.getElementById('otp').focus();
                }, 500);
            } else {
                emailError.textContent = data.message || 'Erreur lors de l\'envoi du code OTP.';
                emailError.classList.add('show');
            }
        } catch (error) {
            emailError.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            emailError.classList.add('show');
            console.error('Erreur:', error);
        } finally {
            btn.disabled = false;
            btn.textContent = 'Continuer';
        }
    });
    
    // Étape 2: Vérifier l'OTP
    otpForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const identifier = document.getElementById('otp-identifier').value;
        const otp = document.getElementById('otp').value;
        const btn = document.getElementById('otp-submit');
        
        if (otp.length !== 6 || isNaN(otp)) {
            otpError.textContent = 'Le code OTP doit contenir 6 chiffres.';
            otpError.classList.add('show');
            return;
        }
        
        otpError.classList.remove('show');
        otpError.textContent = '';
        btn.disabled = true;
        btn.textContent = 'Vérification...';
        
        try {
            const response = await fetch('{{ route("albums.verify_otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ identifier, otp })
            });
            
            const data = await response.json();
            
            if (data.success) {
                otpSuccess.textContent = data.message || 'Connexion réussie!';
                otpSuccess.classList.add('show');
                
                // Rediriger après 1 seconde
                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route("albums.list") }}';
                }, 1000);
            } else {
                otpError.textContent = data.message || 'Code OTP invalide.';
                otpError.classList.add('show');
            }
        } catch (error) {
            otpError.textContent = 'Une erreur est survenue. Veuillez réessayer.';
            otpError.classList.add('show');
            console.error('Erreur:', error);
        } finally {
            btn.disabled = false;
            btn.textContent = 'Se connecter';
        }
    });
    
    // Retour à la saisie d'email
    backBtn.addEventListener('click', () => {
        otpSection.classList.remove('show');
        emailSection.style.display = 'block';
        emailSuccess.classList.remove('show');
        otpError.classList.remove('show');
        document.getElementById('identifier').focus();
    });
</script>
@endsection
