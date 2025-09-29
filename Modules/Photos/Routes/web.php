<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\AlbumController;
use Modules\Photos\Http\Controllers\PhotoController;
use Modules\Photos\Http\Controllers\PaymentController;
use Modules\Photos\Http\Controllers\UploadTokenController;
use App\Http\Middleware\CheckAlbumOwnerToken;
use App\Http\Middleware\CheckInviteToken;
use Modules\Photos\Models\UploadToken;

// Prefix 'photos' pour tout le module
Route::prefix('photos')->group(function () {
    // Page d'accueil du module
    Route::get('/', [AlbumController::class, 'home'])->name('photos.home');
    Route::view('/terms', 'photos::terms')->name('photos.terms');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/share/{token}', [AlbumController::class, 'share'])->name('albums.share');
    Route::post('/albums/{slug}/request-upload-token', [UploadTokenController::class, 'store'])->name('albums.request_upload_token');

    // Routes pour le propriétaire (protégées par owner_token)
    Route::post('/albums/{slug}/update', [AlbumController::class, 'update'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('albums.update');

    Route::delete('/albums/{slug}/destroy', [AlbumController::class, 'destroy'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('albums.destroy');

    // Photos (pour le propriétaire)
    Route::get('/albums/{slug}/photos', [PhotoController::class, 'index'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('photos.index');

    Route::get('/albums/{slug}/upload', [PhotoController::class, 'create'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('photos.create');

    Route::get('/albums/{slug}/{id}', [PhotoController::class, 'show'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('photos.show');

    Route::post('/albums/{slug}/store', [PhotoController::class, 'store'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('photos.store');

    Route::get('/photos/serve/{slug}/{filename}', [PhotoController::class, 'servePhoto'])
        ->name('photos.serve.photo');


    Route::delete('/albums/{slug}/{id}/destroy', [PhotoController::class, 'destroy'])
        ->middleware(CheckAlbumOwnerToken::class)
        ->name('photos.destroy');

    // Upload par token (pour les invités)
    Route::get('/invite/{slug}/photos/{token}', [UploadTokenController::class, 'serveInvitePhotos'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.invite.index');

    Route::get('/invite/{slug}/upload/{token}', [UploadTokenController::class, 'createInvitePhotos'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.invite.upload');

    Route::post('/invite/{slug}/upload/{token}', [UploadTokenController::class, 'storeInvitePhotos'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.invite.store');

    Route::get('/invite/{slug}/photos/{id}/{token}', [UploadTokenController::class, 'showInvitePhotos'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.invite.show');

    // Téléchargement sécurisé (pour les invités)
    Route::get('/invite/{slug}/photos/serve/{token}', [UploadTokenController::class, 'serveInvitePhotos'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.invite.serve');

    Route::get('/albums/{slug}/download-all/{token}', [PhotoController::class, 'downloadAll'])
        ->middleware(CheckInviteToken::class)
        ->name('photos.download.all');

    // Paiements
    Route::get('/albums/{slug}/checkout', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/albums/{slug}/pay', [PaymentController::class, 'store'])->name('payments.store');

    // Album Access Logs For Admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/albums/{slug}/logs', [AlbumController::class, 'logs'])->name('albums.logs');
    });
});