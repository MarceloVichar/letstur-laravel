<?php

namespace App\Domain\Events\Policies;

use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\UserCompanyPolicy;
use App\Domain\Events\Models\Event;

class EventPolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('events view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return $this->checkUserCompany($user, $event, 'events view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('events create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): bool
    {
        return $this->checkUserCompany($user, $event, 'events update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return $this->checkUserCompany($user, $event, 'events delete');
    }
}
