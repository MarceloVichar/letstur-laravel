<?php

namespace App\Domain\Account\Policies;

use App\Domain\Account\Models\User;

class UserPolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('users view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $requestUser): bool
    {
        return $this->checkUserCompany($user, $requestUser, 'users view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('users create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $requestUser): bool
    {
        return $this->checkUserCompany($user, $requestUser, 'users update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $requestUser): bool
    {
        return $this->checkUserCompany($user, $requestUser, 'users delete');
    }
}
