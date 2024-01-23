<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
            if (!Company::find(1)) {
                Company::factory()
                    ->create([
                        'id' => 1,
                        'name' => 'Empresa da praia',
                        'trading_name' => 'Empresa da praia',
                        'cnpj' => '12345678901234',
                        'phone' => '42999123456',
                        'email' => 'empresa_teste@empresa.com'
                    ]);
            }
        }
}
