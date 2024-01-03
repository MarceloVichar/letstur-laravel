<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Resources\Auth\MeResource;
use Illuminate\Http\JsonResponse;

class MeController
{
    public function __invoke(): JsonResponse
    {
        $user = current_user()
            ->loadMissing('roles');;
        return response()->json(MeResource::make($user), 200);
    }
}
