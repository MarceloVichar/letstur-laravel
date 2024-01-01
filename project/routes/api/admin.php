<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

return [
    Route::apiResource('users', UserController::class)
];
