<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        Company::factory()
            ->create([
                'name' => 'Empresa da praia',
                'trading_name' => 'Empresa da praia',
                'cnpj' => '12345678901234',
                'phone' => '42999123456',
                'email' => 'empresa_teste@empresa.com'
            ]);
    }
}
