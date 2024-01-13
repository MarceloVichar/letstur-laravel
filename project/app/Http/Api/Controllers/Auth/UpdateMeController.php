<?php

namespace App\Http\Api\Controllers\Auth;

use App\Domain\Account\Actions\User\UpdateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Http\Api\Requests\Shared\MeRequest;
use App\Http\Api\Resources\Auth\MeResource;
use Illuminate\Http\JsonResponse;

class UpdateMeController
{
    public function __invoke(MeRequest $request): JsonResponse
    {
        $user = current_user();
        $data = UserData::validateAndCreate($request->validated());

        $user = app(UpdateUserAction::class)
            ->execute($user, $data);

        return response()->json(MeResource::make($user), 200);
    }
}
