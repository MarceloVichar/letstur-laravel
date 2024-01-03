<?php

namespace App\Domain\Account\Policies;

use App\Domain\Account\Models\User;

class UserPolicy
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
    public function view(User $user): bool
    {
        return $user->can('users view');
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
    public function update(User $user): bool
    {
        return $user->can('users update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('users delete');
    }

    /**
     * Determine whether the user can delete multiple models.
     */
    public function batchDelete(User $user): bool
    {
        return $user->can('users batch-delete');
    }

    /**
     * Determine whether the user can impersonate other models.
     */
    public function impersonate(User $user): bool
    {
        return $user->can('users impersonate');
    }

    /**
     * Determine whether the user can revoke the impersonation using other models.
     */
    public function revokeImpersonate(User $user): bool
    {
        return $user->can('users revoke-impersonate');
    }
}
