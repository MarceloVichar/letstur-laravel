<?php

namespace App\Domain\Records\Policies;

use App\Domain\Account\Models\User;
use App\Domain\Account\Policies\UserCompanyPolicy;
use App\Domain\Records\Models\Locale;

class LocalePolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('locales view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Locale $locale): bool
    {
        return $this->checkUserCompany($user, $locale, 'locales view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('locales create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Locale $locale): bool
    {
        return $this->checkUserCompany($user, $locale, 'locales update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Locale $locale): bool
    {
        return $this->checkUserCompany($user, $locale, 'locales delete');
    }
}
