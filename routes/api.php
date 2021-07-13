<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraderController;

Route::post('/', [TraderController::class, 'store'])->name('store');
