<?php

use App\Http\Api\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

return [
    Route::apiResource('users', UserController::class)
];
