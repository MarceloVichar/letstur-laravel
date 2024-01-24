<?php

namespace App\Domain\Account\Policies;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;

class CompanyPolicy extends UserCompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('companies view any');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Company $company): bool
    {
        return $this->checkUserCompany($user, $company, 'companies view', 'id');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('companies create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Company $company): bool
    {
        return $this->checkUserCompany($user, $company, 'companies update', 'id');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Company $company): bool
    {
        return $this->checkUserCompany($user, $company, 'companies delete', 'id');
    }
}
