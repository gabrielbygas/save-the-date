<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\AlbumController;
use Modules\Photos\Http\Controllers\PhotoController;
use Modules\Photos\Http\Controllers\PaymentController;

// Prefix 'photos' pour tout le module
Route::prefix('photos')->group(function () {
    
    // Page d'accueil du module
    Route::get('/', [AlbumController::class, 'index'])->name('photos.index');

    // Albums
    Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');
    Route::get('/albums/{id}', [AlbumController::class, 'show'])->name('albums.show');
    Route::post('/albums', [AlbumController::class, 'store'])->name('albums.store');

    // Photos
    Route::get('/albums/{albumId}/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('/albums/{albumId}/photos', [PhotoController::class, 'store'])->name('photos.store');

    // Paiements
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});