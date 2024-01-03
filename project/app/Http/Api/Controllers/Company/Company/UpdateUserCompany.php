<?php

namespace App\Http\Api\Controllers\Company\Company;

use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\UpdateCompanyAction;
use App\Domain\Account\Models\Company;
use App\Http\Api\Requests\Company\CompanyRequest;
use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Shared\Controllers\Controller;

class UpdateUserCompany extends Controller
{
    public function __invoke(CompanyRequest $request)
    {
        $company = Company::find(current_user()->company_id);

        $this->authorize('update', $company);

        $data = CompanyData::validateAndCreate($request->validated());

        $updatedCompany = app(UpdateCompanyAction::class)
            ->execute($company, $data);

        return CompanyResource::make($updatedCompany);
    }
}
