<?php

use App\Http\Api\Controllers\Company\UserController;
use App\Http\Api\Controllers\Company\Company\GetUserCompany;
use App\Http\Api\Controllers\Company\Company\UpdateUserCompany;
use App\Http\Api\Controllers\Company\Records\DriverController;
use Illuminate\Support\Facades\Route;

return [
    Route::apiResource('users', UserController::class),

    Route::get('my-company', GetUserCompany::class),
    Route::put('my-company', UpdateUserCompany::class),

    Route::apiResource('drivers', DriverController::class),
];
