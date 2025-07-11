<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;


Route::view('/', 'welcome')->name('home');

Route::controller(OrderController::class)->group(function () {
    Route::get('/order/create', 'create')->name('order.create');
    Route::post('/order/store', 'store')->name('order.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/terms', 'terms')->name('terms');


require __DIR__.'/auth.php';