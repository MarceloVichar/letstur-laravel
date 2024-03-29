<?php

namespace App\Http\Api\Controllers\Company\Company;

use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\UpdateCompanyAction;
use App\Http\Api\Requests\Company\CompanyRequest;
use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Shared\Controllers\Controller;

class UpdateUserCompany extends Controller
{
    public function __invoke(CompanyRequest $request)
    {
        $company = current_user()->company()->first();

        $this->authorize('update', $company);

        $data = CompanyData::validateAndCreate($request->validated());

        $updatedCompany = app(UpdateCompanyAction::class)
            ->execute($company, $data);

        return response()->json(CompanyResource::make($updatedCompany), 200);
    }
}
