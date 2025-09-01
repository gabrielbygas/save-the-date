<?php

use Illuminate\Support\Facades\Route;
use Modules\Photos\Http\Controllers\PhotosController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('photos', PhotosController::class)->names('photos');
});
