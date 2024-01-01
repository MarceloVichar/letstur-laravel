<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\JsonResponse;

class MeController
{
    public function __invoke(): JsonResponse
    {
        $user = current_user()
            ->loadMissing('roles');;
        return response()->json(UserResource::make($user), 200);
    }
}
