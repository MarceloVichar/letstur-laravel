<?php

namespace App\Domain\Account\Actions\Company;

use App\Domain\Account\Models\Company;

class CreateCompanyAction
{
    public function execute(CompanyData $data): Company
    {
        $dataArray = array_keys_as($data->toArray(), [
            'secondaryPhone' => 'secondary_phone',
            'tradingName' => 'trading_name',
        ]);

        $company = app(Company::class)
            ->create($dataArray);

        return $company;
    }
}
