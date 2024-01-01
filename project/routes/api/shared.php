<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LogoutController;
use App\Http\Api\Controllers\Auth\MeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/me', MeController::class);

        Route::post('/logout', LogoutController::class)->name('logout');
    });

Route::post('/login', LoginController::class);
