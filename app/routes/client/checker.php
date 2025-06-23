<?php


use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Client\CheckerController::class)
    ->prefix("Checker-1")
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Checker1->value .',' . Rules::Administrator->value . ',' . Rules::AdminWarehouse->value])
    ->group(function () {
        Route::get('/',  'index')->name('checker.index');
        Route::get('/get-table-data/{id_data_pengiriman}', 'getData')->name('checker.get');
        Route::get('/print', 'print')->name('checker.print');

    });

Route::controller(App\Http\Controllers\Client\CheckerController::class)
    ->prefix("Checker-1")
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Checker1->value .',' . Rules::Administrator->value ])
    ->group(function () {
        Route::post('/simpan-checker/{id_data_pengiriman}', 'updateChecker')->name('checker.finish');

    });
