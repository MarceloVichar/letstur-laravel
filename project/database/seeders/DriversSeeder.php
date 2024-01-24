<?php

namespace Database\Seeders;

use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Models\Driver;
use Illuminate\Database\Seeder;

class DriversSeeder extends Seeder
{
    public function run()
    {
        Driver::factory()
            ->create([
                'id' => 1,
                'name' => 'José Motorista',
                'document' => '12345678900',
                'phone' => '11999999999',
                'email' => 'ze_motora@email.com',
                'cnh_type' => CnhTypesEnum::D,
                'cnh' => '12345678900',
                'date_of_birth' => '1990-01-01 00:00:00',
                'company_id' => 1,
            ]);
    }
}
