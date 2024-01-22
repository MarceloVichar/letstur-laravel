<?php

namespace App\Domain\Account\Policies;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\User;
use Illuminate\Database\Eloquent\Model;

abstract class UserCompanyPolicy
{
    protected function checkUserCompany(User $user, Model $model, string $permission, string $field = 'company_id'): bool
    {
        $hasPermission = $user->can($permission);

        if (! $user->hasRole(RoleEnum::ADMIN)) {
            return $hasPermission && ($user->company_id === $model->$field);
        }

        return $hasPermission;
    }
}
