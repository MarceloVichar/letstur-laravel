<?php

namespace App\Domain\Records\Policies;

use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\UserCompanyPolicy;
use App\Domain\Records\Models\TourType;

class TourTypePolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('tour-types view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TourType $tourTypes): bool
    {
        return $this->checkUserCompany($user, $tourTypes, 'tour-types view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('tour-types create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TourType $tourTypes): bool
    {
        return $this->checkUserCompany($user, $tourTypes, 'tour-types update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TourType $tourTypes): bool
    {
        return $this->checkUserCompany($user, $tourTypes, 'tour-types delete');
    }
}
