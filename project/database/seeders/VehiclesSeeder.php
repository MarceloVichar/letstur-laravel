<?php

namespace Database\Seeders;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Records\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    public function run()
    {
        Vehicle::factory()
            ->create([
                'id' => 1,
                'license_plate' => 'ABC1234',
                'type' => VehicleTypeEnum::BUS,
                'model' => 'Mercedes Benz Bus',
                'number_of_seats' => 42,
                'cnh_type_required' => CnhTypesEnum::D,
                'owner_name' => 'José dono de ônibus',
                'owner_document' => '12345678900',
                'owner_phone' => '11999999999',
                'owner_email' => 'zezinho@email.com',
                'company_id' => 1,
            ]);
    }
}
