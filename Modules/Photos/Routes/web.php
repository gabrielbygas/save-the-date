<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\AlbumController;
use Modules\Photos\Http\Controllers\PhotoController;
use Modules\Photos\Http\Controllers\PaymentController;

// Prefix 'photos' pour tout le module
Route::prefix('photos')->group(function () {
    
    // Page d'accueil du module
    Route::get('/', [AlbumController::class, 'home'])->name('photos.index');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('albums.create');
    Route::get('/albums/{slug}', [AlbumController::class, 'show'])->name('albums.show');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');
    Route::get('/albums/share/{token}', [AlbumController::class, 'share'])->name('albums.share');


    // Photos
    Route::get('/albums/{slug}/download', [PhotoController::class, 'show'])->name('photos.download');
    Route::get('/albums/{slug}/show', [PhotoController::class, 'show'])->name('photos.show');
    Route::post('/albums/{slug}/upload', [PhotoController::class, 'store'])->name('photos.store');

    // Paiements
    Route::get('/albums/{slug}/checkout', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/albums/{slug}/pay', [PaymentController::class, 'store'])->name('payments.store');

    // Album Access Logs For Admin
    // acceder uniquement si on est admin
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/albums/{slug}/logs', [AlbumController::class, 'logs'])->name('albums.logs');
    });
});