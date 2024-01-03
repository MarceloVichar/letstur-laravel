<?php

use App\Http\Api\Controllers\Admin\UserController;
use App\Http\Api\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;

return [
    Route::apiResource('users', UserController::class),
    Route::apiResource('companies', CompanyController::class)
];
