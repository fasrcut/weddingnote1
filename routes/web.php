<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeddingController;

Route::get('/', [WeddingController::class, 'index'])->name('home');

Route::post('/', [WeddingController::class, 'store'])->name('save.guest');


Route::put('/guest/{id}', [WeddingController::class, 'update'])->name('guest.update');
Route::delete('/guest/{id}', [WeddingController::class, 'destroy'])->name('guest.destroy');
Route::get('/history', [WeddingController::class, 'history'])->name('history');