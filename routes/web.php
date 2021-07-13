<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TraderController;

Route::get('/', [TraderController::class, 'create'])->name('create');
Route::get('/history', [TraderController::class, 'history'])->name('history');
