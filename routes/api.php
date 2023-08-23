<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OrderStatusController;

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

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function (): void {
    Route::group(['prefix' => 'user'], function (): void {
        Route::post('create', [UserController::class, 'register'])->name('register');
        Route::post('login', [UserController::class, 'login'])->name('login');
        Route::post('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('reset-password-token', [UserController::class, 'resetPasswordToken'])->name(
            'reset-password-token'
        );

        Route::group(['middleware' => 'auth.jwt'], function (): void {
            Route::get('/', [UserController::class, 'user'])->name('user');
            Route::get('logout', [UserController::class, 'logout'])->name('logout');
            Route::put('edit', [UserController::class, 'edit'])->name('edit');
            Route::delete('delete', [UserController::class, 'delete'])->name('delete');
            Route::get('orders', [UserController::class, 'orders'])->name('orders');
        });
    });

    Route::group(['prefix' => 'order-status'], function (): void {
        Route::group(['middleware' => 'auth.jwt'], function (): void {
            Route::get('/', [OrderStatusController::class, 'all'])->name('all-order-status');
            Route::post('create', [OrderStatusController::class, 'create'])->name('create-order-status');
            Route::delete('{uuid}', [OrderStatusController::class, 'delete'])->name('delete-order-status');
            Route::get('{uuid}', [OrderStatusController::class, 'show'])->name('find-order-status');
            Route::put('{uuid}', [OrderStatusController::class, 'update'])->name('update-order-status');
        });
    });
});
