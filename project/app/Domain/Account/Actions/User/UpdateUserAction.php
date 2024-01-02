<?php

namespace App\Domain\Account\Actions\User;

use App\Domain\Account\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, UserData $data): User
    {
        $dataArray = $data->toArray();

        if (array_key_exists('password', $dataArray)) {
            $dataArray['password'] = Hash::make($data->password);
        }

        if ($roles = data_get($dataArray, 'roles')) {
            $user->syncRoles($roles);
        }

        return tap($user)
            ->update($dataArray);
    }
}
