<?php


use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Client\CheckerOneController::class)
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Checker2->value .',' . Rules::Administrator->value])

    ->prefix("Checker-2")->group(function () {
        Route::get('/',  'index')->name('checkertwo.index');
        Route::get('/get-table-data', 'getData')->name('checkertwo.get');
        Route::get('/checkpallet/{kode}', 'checkPallet')->name('checkertwo.checkpallet');
        Route::get('/checkitem/{kode}/{qty}/{id_data_pengiriman}', 'checkItem')->name('checkertwo.checkitem');
        Route::get('/show-data/{id_data_pengiriman}', 'getShowData')->name('checkertwo.show');
        Route::get('/get-data-kebutuhan/{id_data_pengiriman}', 'getDataKebutuhan')->name('checkertwo.getKebutuhan');

        Route::post('/simpan-data', 'store')->name('checkertwo.store');
        Route::post('/simpan-checker/{id}', 'updateChecker')->name('checkertwo.store.checker');

        Route::delete('/delete-pallet/{id}', 'destroyPallet')->name('checkertwo.delete.pallet');
    });
