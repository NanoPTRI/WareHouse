<?php

use Illuminate\Support\Facades\Route;

Route::controller(App\Http\Controllers\Controller::class)
    ->middleware('auth')
    ->group(function () {
    Route::get('/',  'index')->name('index');
});

require_once __DIR__ . '/client/transaction.php';
require_once __DIR__ . '/client/checker2.php';
require_once __DIR__ . '/client/checker1.php';
require_once __DIR__ . '/client/checker.php';
require_once __DIR__ . '/auth/auth.php';
require_once __DIR__ . '/admin/admin.php';
require_once __DIR__ . '/admin/pallet.php';
require_once __DIR__ . '/admin/user.php';




Route::post('/clear-temp-session', function () {
    session()->forget('imported_excel_data');
    return response()->json(['status' => 'cleared']);
})->middleware('auth')
->name('clear-temp-session');
