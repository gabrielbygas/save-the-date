<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\AlbumController;
use Modules\Photos\Http\Controllers\PhotoController;
use Modules\Photos\Http\Controllers\PaymentController;

Route::prefix('photos')->group(function () {

    // Albums
    Route::get('/albums', [AlbumController::class, 'apiIndex']);
    Route::get('/albums/{id}', [AlbumController::class, 'apiShow']);
    Route::post('/albums', [AlbumController::class, 'apiStore']);

    // Photos
    Route::get('/albums/{albumId}/photos', [PhotoController::class, 'apiIndex']);
    Route::post('/albums/{albumId}/photos', [PhotoController::class, 'apiStore']);

    // Paiements
    Route::get('/payments', [PaymentController::class, 'apiIndex']);
    Route::post('/payments', [PaymentController::class, 'apiStore']);
});