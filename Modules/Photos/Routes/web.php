<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\AlbumController;
use Modules\Photos\Http\Controllers\PhotoController;
use Modules\Photos\Http\Controllers\PaymentController;
use App\Http\Middleware\CheckAlbumOwnerToken;

// Prefix 'photos' pour tout le module
Route::prefix('photos')->group(function () {

    // Page d'accueil du module
    Route::get('/', [AlbumController::class, 'home'])->name('photos.home');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/share/{token}', [AlbumController::class, 'share'])->name('albums.share');
    Route::post('/albums/{slug}/request-upload-token', [AlbumController::class, 'requestUploadToken'])->name('albums.request_upload_token');
    Route::post('/albums/{slug}/update', [AlbumController::class, 'update'])->middleware(CheckAlbumOwnerToken::class)->name('albums.update');
    Route::delete('/albums/{slug}/destroy', [AlbumController::class, 'destroy'])->middleware(CheckAlbumOwnerToken::class)->name('albums.destroy');



    // Photos
    Route::get('/albums/{slug}/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/albums/{slug}/upload', [PhotoController::class, 'create'])->name('photos.create');
    Route::get('/albums/{slug}/{id}', [PhotoController::class, 'show'])->name('photos.show');
    Route::post('/albums/{slug}/store', [PhotoController::class, 'store'])->name('photos.store');

    // Upload par token (pour les invités)
    Route::get('/albums/{slug}/upload/{token}', [PhotoController::class, 'createWithToken'])->name('photos.upload.token');
    Route::post('/albums/{slug}/upload/{token}', [PhotoController::class, 'storeWithToken'])->name('photos.store.token');

    // Téléchargement sécurisé
    Route::get('/albums/{slug}/photos/{photo}/serve/{token}', [PhotoController::class, 'serve'])->name('photos.serve'); // Téléchargement sécurisé
    Route::get('/albums/{slug}/download-all/{token}', [PhotoController::class, 'downloadAll'])->name('photos.download.all'); // Téléchargement de toutes les photos par token
    Route::delete('/albums/{slug}/{id}/destroy', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Paiements
    Route::get('/albums/{slug}/checkout', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/albums/{slug}/pay', [PaymentController::class, 'store'])->name('payments.store');

    // Album Access Logs For Admin
    // acceder uniquement si on est admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/albums/{slug}/logs', [AlbumController::class, 'logs'])->name('albums.logs');
    });
});