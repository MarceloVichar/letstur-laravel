<?php

namespace App\Domain\Records\Actions\Driver;

use App\Domain\Records\Models\Driver;

class CreateDriverAction
{
    public function execute(DriverData $data): Driver
    {
        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'cnhType' => 'cnh_type',
            'dateOfBirth' => 'date_of_birth',
        ]);

        $driver = app(Driver::class)
            ->create($dataArray);

        return $driver;
    }
}
