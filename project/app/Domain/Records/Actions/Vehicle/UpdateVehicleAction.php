<?php

namespace App\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Models\Vehicle;

class UpdateVehicleAction
{
    public function execute(Vehicle $vehicle, VehicleData $data): Vehicle
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

        return tap($vehicle)
            ->update($dataArray);
    }
}
