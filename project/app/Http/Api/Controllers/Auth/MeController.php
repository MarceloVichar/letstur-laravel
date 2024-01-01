<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Resources\Auth\UserResource;
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
