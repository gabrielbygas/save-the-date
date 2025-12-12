@extends('photos::layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 8px;">Ajouter des photos à {{ $album->album_title }}</h1>
        <p style="font-size: 15px; color: #666; margin-bottom: 4px;">Mariage de {{ ucfirst($album->client->mr_first_name) }} 💍 {{ ucfirst($album->client->mrs_first_name) }}</p>
        <p style="font-size: 13px; color: #999;">📅 {{ \Carbon\Carbon::parse($album->wedding_date)->format('d M Y') }}</p>
    </div>

    <!-- Upload Form -->
    <form action="{{ route('photos.store', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Drag & Drop Area -->
        <div style="border: 2px dashed #c4b5fd; border-radius: 12px; padding: 40px 20px; text-align: center; background: #f9f5ff; cursor: pointer; transition: all 0.2s;" id="dropArea">
            <input type="file" name="photos[]" id="photos" style="display: none;" multiple accept="image/jpeg,image/png,image/jpg,image/gif,video/mp4,video/mov,video/ogg" required>
            
            <div style="font-size: 32px; margin-bottom: 12px;">📸</div>
            <label for="photos" style="cursor: pointer;">
                <p style="font-size: 15px; font-weight: 600; color: #7c3aed; margin-bottom: 4px;">Cliquez ou glissez des photos</p>
                <p style="font-size: 13px; color: #999;">Max 10 fichiers, 10MB chacun</p>
            </label>
        </div>

        <!-- Selected Files Info -->
        <p style="font-size: 13px; color: #666; margin-top: 12px; min-height: 20px;" id="file-upload-info"></p>

        <!-- Error Message -->
        <div id="upload-error" style="display: none; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-top: 16px; font-size: 14px;"></div>

        @error('photos.*')
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-top: 16px; font-size: 14px;">{{ $message }}</div>
        @enderror

        <!-- Submit Button -->
        <div style="text-align: center; margin-top: 32px;">
            <button type="submit" style="background: #7c3aed; color: white; padding: 12px 32px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.2s; font-size: 15px;">
                Uploader les photos
            </button>
        </div>
    </form>

    <!-- Back Button -->
    <div style="text-align: center; margin-top: 32px; padding-top: 32px; border-top: 1px solid #e9d5ff;">
        <a href="{{ route('photos.index', ['slug' => $album->slug, 'owner_token' => $album->owner_token]) }}" style="color: #7c3aed; text-decoration: none; font-weight: 500;">
            ← Retour à la galerie
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const fileInput = document.getElementById('photos');
        const errorBox = document.getElementById('upload-error');
        const fileUploadInfo = document.getElementById('file-upload-info');
        const dropArea = document.getElementById('dropArea');

        // Drag and drop
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.style.background = '#f3e8ff';
                dropArea.style.borderColor = '#7c3aed';
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, () => {
                dropArea.style.background = '#f9f5ff';
                dropArea.style.borderColor = '#c4b5fd';
            });
        });

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFiles(files);
        });

        function handleFiles(files) {
            errorBox.style.display = 'none';
            errorBox.textContent = '';
            fileUploadInfo.textContent = '';

            if (files.length > 10) {
                errorBox.textContent = '🚫 Maximum 10 fichiers autorisés. Vous en avez sélectionné ' + files.length + '.';
                errorBox.style.display = 'block';
                return;
            }

            if (files.length > 0) {
                const fileNames = Array.from(files).map(f => f.name).join(', ');
                fileUploadInfo.textContent = '✅ ' + files.length + ' fichier(s) sélectionné(s)';
                fileUploadInfo.style.color = '#16a34a';
            }
        }

        fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

        form.addEventListener('submit', (e) => {
            if (fileInput.files.length > 10) {
                e.preventDefault();
                errorBox.textContent = '🚫 Vous ne pouvez pas uploader plus de 10 photos à la fois.';
                errorBox.style.display = 'block';
            }
        });
    });
</script>
@endsection
