<?php

namespace App\Http\Api\Controllers\Admin;

use App\Domain\Account\Actions\Company\CreateCompanyData;
use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\DeleteCompanyAction;
use App\Domain\Account\Actions\Company\UpdateCompanyAction;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Strategies\CreateCompanyActionStrategy;
use App\Http\Api\Requests\Admin\CompanyRequest;
use App\Http\Api\Resources\Shared\CompanyResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class CompanyController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', Company::class);

        return pagination(Company::query())
            ->allowedFilters([
                AllowedFilter::partial('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('trading_name'),
                AllowedFilter::partial('cnpj'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->defaultSort('created_at')
            ->resource(CompanyResource::class);
    }

    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return CompanyResource::make($company);
    }

    public function store(CompanyRequest $request)
    {
        $this->authorize('companies create');

        $data = CreateCompanyData::validateAndCreate($request->validated());

        $company = app(CreateCompanyActionStrategy::class)
            ->execute($data);

        return CompanyResource::make($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $this->authorize('companies update');

        $data = CompanyData::validateAndCreate($request->validated());

        $company = app(UpdateCompanyAction::class)
            ->execute($company, $data);

        return CompanyResource::make($company);
    }

    public function destroy(Company $company)
    {
        $this->authorize('companies delete');

        app(DeleteCompanyAction::class)
            ->execute($company);

        return response()->noContent();
    }
}
