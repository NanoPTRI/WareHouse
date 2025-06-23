<?php

use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Admin\AdminController::class)
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Supervisor->value . ',' . Rules::Administrator->value])
    ->prefix("Admin")->group(function () {
    Route::get('/',  'index')->name('admin.index');
});

Route::controller(App\Http\Controllers\Admin\TransactionController::class)
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Supervisor->value . ',' . Rules::Administrator->value])
    ->prefix("Admin/Transaction")->group(function () {
    Route::get('/',  'index')->name('admin.transaction.index');
    Route::get('/get/{date}',  'get')->name('admin.transaction.get');
    Route::get('/show/{id}',  'show')->name('admin.transaction.show');
    Route::get('/print/{id}',  'print')->name('admin.transaction.print');
    Route::get('/running',  'running')->name('admin.transaction.running');
    Route::get('/getRunning/{date}',  'getRunning')->name('admin.transaction.getrunning');
    Route::delete('/delete/{id}',  'destroy')->name('admin.transaction.destroy');
    Route::get('/edit/{id}',  'edit')->name('admin.transaction.edit');
    Route::patch('/update/{id}',  'update')->name('admin.transaction.update');
    Route::get('/detail-data/{id}',  'detail')->name('admin.transaction.detail');
    Route::get('/get-detail-data/{id_data_pengiriman}', 'getDetailData')->name('admin.transaction.detail.get');
});
