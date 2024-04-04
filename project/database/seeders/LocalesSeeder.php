<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\Locale;
use Illuminate\Database\Seeder;

class LocalesSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;

        Locale::factory()
            ->create([
                'name' => 'Praça do centro',
                'zip_code' => '12345678',
                'street' => 'Rua do centro',
                'number' => '123',
                'district' => 'Centro',
                'city' => 'Recife',
                'uf' => 'PE',
                'responsible_name' => 'João responsável',
                'responsible_phone' => '11999999999',
                'company_id' => $company_id,
            ]);
    }
}
