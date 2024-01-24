<?php

namespace App\Domain\Account\Actions\Company;

use App\Domain\Account\Models\Company;

class DeleteCompanyAction
{
    public function execute(Company $company): bool
    {
        return $company->delete();
    }
}
