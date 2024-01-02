<?php

namespace App\Domain\Account\Actions\User;

use App\Domain\Account\Models\User;

class DeleteUserAction
{
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
