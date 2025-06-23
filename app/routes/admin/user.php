<?php

use App\Rules;
use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Admin\UserController::class)
    ->prefix('Admin/User')
    ->middleware(['auth',\App\Http\Middleware\RoleMiddleware::class.":" . Rules::Supervisor->value . ',' . Rules::Administrator->value])

    ->group(function () {
        Route::get('/',  'index')->name('admin.user.index');
        Route::get('/get',  'get')->name('admin.user.get');
        Route::get('/create',  'create')->name('admin.user.create');
        Route::get('/edit/{id}',  'edit')->name('admin.user.edit');
        Route::post('/store',  'store')->name('admin.user.store');
        Route::patch('/update/{id}',  'update')->name('admin.user.update');
        Route::delete('/destroy/{id}',  'destroy')->name('admin.user.delete');
});
