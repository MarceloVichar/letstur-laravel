<?php

namespace App\Domain\Account\Strategies;

use App\Domain\Account\Actions\Company\CreateCompanyData;
use App\Domain\Account\Actions\Company\CompanyData;
use App\Domain\Account\Actions\Company\CreateCompanyAction;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Actions\User\CreateUserAction;
use App\Domain\Account\Actions\User\UserData;
use App\Domain\Account\Models\User;
use Illuminate\Support\Facades\DB;

class CreateCompanyActionStrategy
{
    public function execute(CreateCompanyData $data): ?Company
    {
        try {
            DB::beginTransaction();

            $companyData = CompanyData::validateAndCreate($data);

            $company = $this->createCompany($companyData);

            $userData = UserData::validateAndCreate([
                'name' => $data->ownerName,
                'email' => $data->ownerEmail,
                'password' => $data->ownerPassword,
                'roles' => [
                   RoleEnum::COMPANY_ADMIN,
                ],
                'companyId' => $company->id,
            ]);

            $this->createCompanyOwner($userData);

            DB::commit();

            return $company;
        } catch (\Exception $exception) {
            DB::rollBack();
            report($exception);
        }

        return null;
    }

    private function createCompany(CompanyData $data): Company
    {
        return app(CreateCompanyAction::class)
            ->execute($data);
    }

    private function createCompanyOwner(UserData $data): User
    {

        return app(CreateUserAction::class)
            ->execute($data);
    }
}
