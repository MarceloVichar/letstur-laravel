<?php

use App\Http\Api\Controllers\Company\UserController;
use App\Http\Api\Controllers\Company\Company\GetUserCompany;
use App\Http\Api\Controllers\Company\Company\UpdateUserCompany;
use App\Http\Api\Controllers\Company\Records\DriverController;
use App\Http\Api\Controllers\Company\Records\VehicleController;
use App\Http\Api\Controllers\Company\Records\TourGuideController;
use App\Http\Api\Controllers\Company\Records\LocaleController;
use App\Http\Api\Controllers\Company\Records\TourTypeController;
use App\Http\Api\Controllers\Company\Records\TourController;
use App\Http\Api\Controllers\Company\Events\EventController;
use Illuminate\Support\Facades\Route;

return [
    Route::apiResource('users', UserController::class),

    Route::get('my-company', GetUserCompany::class),
    Route::put('my-company', UpdateUserCompany::class),

    Route::apiResource('drivers', DriverController::class),
    Route::apiResource('vehicles', VehicleController::class),
    Route::apiResource('tour-guides', TourGuideController::class),
    Route::apiResource('locales', LocaleController::class),
    Route::apiResource('tour-types', TourTypeController::class),
    Route::apiResource('tours', TourController::class),
    Route::apiResource('events', EventController::class)
];
