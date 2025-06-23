<?php

use App\Rules;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->controller(App\Http\Controllers\Auth\AuthController::class)
    ->group(function () {
        Route::get('/login', 'loginPage')->name('login');
        Route::post('/login', 'store')->name('login.store');
    });

Route::middleware('auth')->controller(App\Http\Controllers\Auth\AuthController::class)
    ->middleware('auth')
    ->group(function () {
        Route::get('/logout', 'logout')->name('logout');
    });
