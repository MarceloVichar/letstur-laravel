<?php

namespace App\Domain\Account\Actions\User;

use App\Domain\Account\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction
{
    public function execute(User $user, UserData $data): User
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
        ]);

        if (array_key_exists('password', $dataArray)) {
            $dataArray['password'] = Hash::make($data->password);
        }

        if ($roles = data_get($dataArray, 'roles')) {
            $user->syncRoles($roles);
        }

        $user->refresh();

        $user->update($dataArray);

        return $user;
    }
}
