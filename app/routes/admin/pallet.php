<?php


use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Admin\PalletController::class)
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Supervisor->value . ',' . Rules::Administrator->value])

    ->prefix("Admin/pallet")->group(function () {
    Route::get('/',  'index')->name('admin.pallet.index');
    Route::get('/get',  'get')->name('admin.pallet.get');
    Route::get('/qrshow/{id}',  'qrshow')->name('admin.pallet.qr.show');
    Route::get('/create',  'create')->name('admin.pallet.create');
    Route::get('/edit/{id}',  'edit')->name('admin.pallet.edit');
    Route::post('/store',  'store')->name('admin.pallet.store');
    Route::patch('/update/{id}',  'update')->name('admin.pallet.update');
    Route::delete('/destroy/{id}',  'destroy')->name('admin.pallet.delete');
});
