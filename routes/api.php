<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\OrderController;

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


/**
 * @group Unauthenticated APIs
 *
 * APIs that do not require User authentication
 */

/**
 * @group Authenticated APIs
 *
 * APIs that require User authentication
 */

Route::post('auth/login', [LoginController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('order/product', [OrderController::class, 'order'])->name('order');
    Route::post('auth/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::post('auth/logout-from-all-sessions', [LogoutController::class, 'logoutFromAllSessions'])->name('logoutFromAllSessions');
});
