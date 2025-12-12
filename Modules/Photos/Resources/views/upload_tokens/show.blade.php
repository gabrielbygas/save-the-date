@extends('photos::layouts.app')

@section('title', 'Télécharger vos photos - Albums Photo')

@section('content')
<style>
    .upload-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 20px rgba(0,0,0,0.08);
        padding: 40px;
    }
    
    .upload-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .upload-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .upload-header p {
        color: #666;
        font-size: 15px;
    }
    
    .info-box {
        background: #f0ebff;
        border: 1px solid #d8c9ff;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 24px;
        font-size: 14px;
        color: #1a1a1a;
        line-height: 1.6;
    }
    
    .drop-zone {
        border: 2px dashed #d8c9ff;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        background: #fafafa;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 24px;
    }
    
    .drop-zone:hover,
    .drop-zone.dragover {
        background: #f0ebff;
        border-color: #ec407a;
    }
    
    .drop-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }
    
    .drop-title {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
    }
    
    .drop-desc {
        font-size: 14px;
        color: #666;
        margin-bottom: 16px;
    }
    
    input[type="file"] {
        display: none;
    }
    
    .btn-select {
        display: inline-block;
        padding: 10px 20px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-select:hover {
        background: #d81b60;
    }
    
    .files-list {
        margin-bottom: 24px;
    }
    
    .file-item {
        background: #fafafa;
        border: 1px solid #f0f0f0;
        border-radius: 10px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .file-name {
        font-size: 14px;
        font-weight: 500;
        color: #1a1a1a;
        flex: 1;
        word-break: break-all;
    }
    
    .file-size {
        font-size: 13px;
        color: #999;
        margin-left: 12px;
    }
    
    .btn-remove {
        background: none;
        border: none;
        color: #ff3b30;
        cursor: pointer;
        font-size: 16px;
        margin-left: 12px;
    }
    
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: #ec407a;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .btn-submit:hover:not(:disabled) {
        background: #d81b60;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(236, 64, 122, 0.3);
    }
    
    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .error-message {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #ff3b30;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 24px;
        display: none;
    }
    
    .error-message.show {
        display: block;
    }
    
    @media (max-width: 600px) {
        .upload-container { padding: 30px 20px; }
        .upload-header h1 { font-size: 24px; }
    }
</style>

<div class="upload-container">
    <div class="upload-header">
        <h1>📸 Télécharger vos photos</h1>
        <p>{{ $album->album_title }}</p>
    </div>
    
    <div class="info-box">
        ℹ️ Vous pouvez télécharger jusqu'à <strong>{{ $uploadToken->max_uses }}</strong> fichier(s). Ce lien expire le <strong>{{ \Carbon\Carbon::parse($uploadToken->expires_at)->format('d/m/Y') }}</strong>.
    </div>
    
    <div class="error-message" id="error-message"></div>
    
    <form id="upload-form" enctype="multipart/form-data" novalidate>
        @csrf
        
        <input type="hidden" name="token" value="{{ $uploadToken->token }}">
        
        <label for="file-input" class="drop-zone" id="drop-zone">
            <div class="drop-icon">📤</div>
            <div class="drop-title">Glissez-déposez vos photos ici</div>
            <div class="drop-desc">ou cliquez pour sélectionner</div>
            <button type="button" class="btn-select">Parcourir les fichiers</button>
        </label>
        <input type="file" id="file-input" name="files[]" multiple accept="image/*,video/*">
        
        <div class="files-list" id="files-list"></div>
        
        <button type="submit" class="btn-submit" id="submit-btn" disabled>
            📤 Télécharger {{ $uploadToken->max_uses }} fichier(s)
        </button>
    </form>
</div>

<script>
    const form = document.getElementById('upload-form');
    const fileInput = document.getElementById('file-input');
    const dropZone = document.getElementById('drop-zone');
    const filesList = document.getElementById('files-list');
    const submitBtn = document.getElementById('submit-btn');
    const errorMsg = document.getElementById('error-message');
    
    let selectedFiles = [];
    
    // Drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
        dropZone.addEventListener(event, e => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.toggle('dragover', ['dragenter', 'dragover'].includes(event));
        });
    });
    
    dropZone.addEventListener('drop', e => {
        selectedFiles = [...e.dataTransfer.files];
        updateFilesList();
    });
    
    fileInput.addEventListener('change', e => {
        selectedFiles = [...e.target.files];
        updateFilesList();
    });
    
    dropZone.addEventListener('click', () => fileInput.click());
    
    function updateFilesList() {
        filesList.innerHTML = '';
        const maxFiles = {{ $uploadToken->max_uses }};
        
        if (selectedFiles.length > maxFiles) {
            errorMsg.textContent = `Maximum ${maxFiles} fichier(s) autorisé(s)`;
            errorMsg.classList.add('show');
            selectedFiles = Array.from(selectedFiles).slice(0, maxFiles);
        } else {
            errorMsg.classList.remove('show');
        }
        
        selectedFiles.forEach((file, idx) => {
            const size = (file.size / 1024 / 1024).toFixed(2);
            const item = document.createElement('div');
            item.className = 'file-item';
            item.innerHTML = `
                <span class="file-name">${file.name}</span>
                <span class="file-size">${size}MB</span>
                <button type="button" class="btn-remove" onclick="removeFile(${idx})">✕</button>
            `;
            filesList.appendChild(item);
        });
        
        submitBtn.disabled = selectedFiles.length === 0;
        submitBtn.textContent = `📤 Télécharger ${selectedFiles.length}/${{{ $uploadToken->max_uses }})}`;
    }
    
    function removeFile(idx) {
        selectedFiles.splice(idx, 1);
        updateFilesList();
    }
    
    form.addEventListener('submit', async e => {
        e.preventDefault();
        
        const formData = new FormData();
        formData.append('token', fileInput.closest('form').querySelector('input[name="token"]').value);
        selectedFiles.forEach(file => formData.append('files[]', file));
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Téléchargement en cours...';
        
        try {
            const response = await fetch('{{ route("upload-tokens.upload", $uploadToken->token) }}', {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            
            const data = await response.json();
            
            if (data.success) {
                submitBtn.textContent = '✓ Succès!';
                setTimeout(() => window.location.href = data.redirect || '/', 2000);
            } else {
                throw new Error(data.message || 'Erreur lors du téléchargement');
            }
        } catch (error) {
            errorMsg.textContent = error.message;
            errorMsg.classList.add('show');
            submitBtn.disabled = false;
            submitBtn.textContent = '📤 Télécharger';
        }
    });
</script>
@endsection
