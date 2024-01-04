<?php

namespace App\Domain\Records\Policies;

use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\UserCompanyPolicy;
use App\Domain\Records\Models\TourGuide;

class TourGuidePolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('tour-guides view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TourGuide $tourGuide): bool
    {
        return $this->checkUserCompany($user, $tourGuide, 'tour-guides view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('tour-guides create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TourGuide $tourGuide): bool
    {
        return $this->checkUserCompany($user, $tourGuide, 'tour-guides update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TourGuide $tourGuide): bool
    {
        return $this->checkUserCompany($user, $tourGuide, 'tour-guides delete');
    }
}
