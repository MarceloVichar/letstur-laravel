<?php

namespace App\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Models\Vehicle;

class CreateVehicleAction
{
    public function execute(VehicleData $data): Vehicle
    {

        $dataArray = array_keys_as($data->toArray(), [
            'companyId' => 'company_id',
            'licensePlate' => 'license_plate',
            'numberOfSeats' => 'number_of_seats',
            'cnhTypeRequired' => 'cnh_type_required',
            'ownerDocument' => 'owner_document',
            'ownerEmail' => 'owner_email',
            'ownerName' => 'owner_name',
            'ownerPhone' => 'owner_phone',
        ]);

        $vehicle = app(Vehicle::class)
            ->create($dataArray);

        return $vehicle;
    }
}
