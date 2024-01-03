<?php

namespace App\Domain\Records\Policies;

use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\UserCompanyPolicy;
use App\Domain\Records\Models\Driver;

class DriverPolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('drivers view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Driver $driver): bool
    {
        return $this->checkUserCompany($user, $driver, 'drivers view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('drivers create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Driver $driver): bool
    {
        return $this->checkUserCompany($user, $driver, 'drivers update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Driver $driver): bool
    {
        return $this->checkUserCompany($user, $driver, 'drivers delete');
    }
}
