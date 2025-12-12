<div id="alerts-container" class="position-fixed top-0 start-0 p-3" style="z-index: 9999; width: 100%; max-width: 500px;">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show slide-in" role="alert">
            <strong>✓ Succès!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show slide-in" role="alert">
            <strong>✗ Erreur!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show slide-in" role="alert">
            <strong>⚠ Vérification!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<script>
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
</script>
