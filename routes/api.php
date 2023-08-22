<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::post('create', [UserController::class, 'register'])->name('register');
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::post('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');

        Route::group(['middleware' => 'auth.jwt'], function () {
            Route::get('/', [UserController::class, 'user'])->name('user');
            Route::get('logout', [UserController::class, 'logout'])->name('logout');
            Route::put('edit', [UserController::class, 'edit'])->name('edit');
            Route::delete('delete', [UserController::class, 'delete'])->name('delete');
        });
    });
});

