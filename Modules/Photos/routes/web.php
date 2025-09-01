<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\PhotosController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('photos', PhotosController::class)->names('photos');
});
