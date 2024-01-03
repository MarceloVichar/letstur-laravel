<?php

namespace App\Http\Api\Controllers\Company\Company;

use App\Domain\Account\Models\Company;
use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Shared\Controllers\Controller;

class GetUserCompany extends Controller
{
    public function __invoke()
    {

        $company = Company::find(current_user()->company_id);

        $this->authorize('view', $company);

        return CompanyResource::make($company);
    }
}
