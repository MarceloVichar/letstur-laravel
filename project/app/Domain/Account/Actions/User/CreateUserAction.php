<?php

namespace App\Domain\Account\Actions\User;

use App\Domain\Account\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(UserData $data): User
    {
        $dataArray = $data->toArray();

        $dataArray['password'] = Hash::make($dataArray['password']);

        $user = app(User::class)
            ->create($dataArray);

        if ($roles = data_get($dataArray, 'roles')) {
            $user->assignRole($roles);
        }

        return $user;
    }
}
