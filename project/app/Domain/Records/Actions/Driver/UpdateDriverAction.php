<?php

namespace App\Domain\Records\Actions\Driver;

use App\Domain\Records\Models\Driver;

class UpdateDriverAction
{
    public function execute(Driver $driver, DriverData $data): Driver
    {
        $dataArray = array_keys_as($data->toArray(), [
            'cnhType' => 'cnh_type',
            'dateOfBirth' => 'date_of_birth',
            'companyId' => 'company_id',
        ]);

        return tap($driver)
            ->update($dataArray);
    }
}
