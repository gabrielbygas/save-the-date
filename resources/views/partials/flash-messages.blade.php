<style>
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        max-width: 400px;
        padding: 16px 20px;
        border-radius: 10px;
        font-size: 14px;
        animation: slideIn 0.3s ease;
        z-index: 1000;
    }
    
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    
    .alert-error {
        background: #fee2e2;
        color: #7f1d1d;
        border: 1px solid #fecaca;
    }
    
    .alert-warning {
        background: #fef3c7;
        color: #78350f;
        border: 1px solid #fcd34d;
    }
    
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
    
    .alert.hide { animation: slideOut 0.3s ease forwards; }
</style>

@if ($message = Session::get('success'))
    <div class="alert alert-success" id="alert-success">✓ {{ $message }}</div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-error" id="alert-error">✗ {{ $message }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-warning" id="alert-errors">
        ⚠ Veuillez corriger les erreurs
    </div>
@endif

<script>
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.classList.add('hide');
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
</script>
