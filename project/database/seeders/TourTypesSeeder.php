<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\TourType;
use Illuminate\Database\Seeder;

class TourTypesSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;

        $tourTypes = [
            [
                'name' => 'Passeio comum',
                'is_exclusive' => false,
                'is_transfer' => false,
                'color' => '#0000FF',
                'company_id' => $company_id,
            ],
            [
                'name' => 'Transfer in Exclusive',
                'is_exclusive' => true,
                'is_transfer' => true,
                'color' => '#FF0000',
                'company_id' => $company_id,
            ],
            [
                'name' => 'Transfer in',
                'is_exclusive' => false,
                'is_transfer' => true,
                'color' => '#DDDDDD',
                'company_id' => $company_id,
            ],
            [
                'name' => 'Transfer out Exclusive',
                'is_exclusive' => true,
                'is_transfer' => true,
                'color' => '#00FF00',
                'company_id' => $company_id,
            ],
            [
                'name' => 'Transfer out',
                'is_exclusive' => false,
                'is_transfer' => true,
                'color' => '#DDDDDD',
                'company_id' => $company_id,
            ],
        ];

        foreach ($tourTypes as $tourType) {
            TourType::factory()
                ->create($tourType);
        }
    }
}
