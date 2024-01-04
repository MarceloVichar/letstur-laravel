<?php

namespace App\Domain\Records\Actions\Vehicle;

use App\Domain\Records\Models\Vehicle;

class DeleteVehicleAction
{
    public function execute(Vehicle $vehicle): bool
    {
        return $vehicle->delete();
    }
}
