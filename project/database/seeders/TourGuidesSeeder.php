<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\TourGuide;
use Illuminate\Database\Seeder;

class TourGuidesSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;

        TourGuide::factory()
            ->create([
                'name' => 'João Guia',
                'document' => '12345678901',
                'phone' => '11988888888',
                'email' => 'jao_guia@email.com',
                'company_id' => $company_id,
            ]);
    }
}
