<?php

use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Client\CheckerTwoController::class)
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Checker3->value . ',' . Rules::Administrator->value ])

    ->prefix("Checker-3")->group(function () {
    Route::get('/',  'index')->name('checkerthree.index');
    Route::get('/get',  'get')->name('checkerthree.get');
    Route::get('/get-modal/{id}',  'getModal')->name('checkerthree.get.modal');
    Route::patch('/update/{kode}',  'update')->name('checkerthree.update');
    Route::patch('/updateqtycustom/{id}',  'updateQtyCustom')->name('checkerthree.update.qtycustom');
    Route::patch('/updateqtysingle/{id}',  'updateQtySingle')->name('checkerthree.update.qtysingle');
    Route::post('/store',  'store')->name('checkerthree.store');
});
