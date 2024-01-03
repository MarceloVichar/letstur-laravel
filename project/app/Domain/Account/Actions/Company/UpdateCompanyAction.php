<?php

namespace App\Domain\Account\Actions\Company;

use App\Domain\Account\Models\Company;

class UpdateCompanyAction
{
    public function execute(Company $company, CompanyData $data): Company
    {
        $dataArray = array_keys_as($data->toArray(), [
            'secondaryPhone' => 'secondary_phone',
            'tradingName' => 'trading_name',
        ]);

        return tap($company)
            ->update($dataArray);
    }
}
