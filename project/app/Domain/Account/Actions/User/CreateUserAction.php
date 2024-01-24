<?php

namespace App\Domain\Account\Actions\User;

use App\Domain\Account\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(UserData $data): User
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
        ]);

        $dataArray['password'] = Hash::make($dataArray['password']);

        $user = app(User::class)
            ->create($dataArray);

        if ($roles = data_get($dataArray, 'roles')) {
            $user->assignRole($roles);
        }

        return $user;
    }
}
