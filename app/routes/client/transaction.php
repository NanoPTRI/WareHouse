<?php


use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Client\TransactionController::class)
    ->prefix("Transaction")
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::AdminSales->value.',' . Rules::Administrator->value ])

    ->group(function () {
        Route::get('/',  'index')->name('transaction.index');
        Route::get('/get-table-data',  'getTable')->name('transaction.get.table');
        Route::post('/store',  'store')->name('transaction.store');
        Route::post('/storeTransaction',  'storeTransaction')->name('transaction.store.transaction');


    });

Route::controller(App\Http\Controllers\Client\TransactionController::class)
    ->prefix("Transaction")
    ->group(function () {

        Route::get('/view',  'view')->name('transaction.view');
        Route::get('/get-view-data',  'getViewData')->name('transaction.view.get');
        Route::get('/edit/{id}',  'edit')->name('transaction.edit');
        Route::patch('/update/{id}',  'update')->name('transaction.update');
        Route::get('/show-data/{id}',  'show')->name('transaction.show');
        Route::post('/simpan-plan/{id}', 'updateConfirmed')->name('transaction.finish');
        Route::get('/get-show-data/{id_data_pengiriman}', 'getShowData')->name('transaction.show.get');
    });

