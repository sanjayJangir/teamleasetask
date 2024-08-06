<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('/fetch-sync', [ApiController::class, 'fetchSync']);
Route::get('/fetch-async', [ApiController::class, 'fetchAsync']);


Route::get('import', function () {
    return view('import');
});

Route::post('import', [UserController::class, 'import'])->name('users.import');
