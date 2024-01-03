<?php

use App\Http\Api\Controllers\Company\UserController;
use App\Http\Api\Controllers\Company\Company\GetUserCompany;
use App\Http\Api\Controllers\Company\Company\UpdateUserCompany;
use Illuminate\Support\Facades\Route;

return [
    Route::apiResource('users', UserController::class),

    Route::get('my-company', GetUserCompany::class),
    Route::put('my-company', UpdateUserCompany::class),
];
