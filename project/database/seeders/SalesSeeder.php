<?php

namespace Database\Seeders;

use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run()
    {
        Sale::factory()
            ->attachEvent(1)
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'seller_id' => 3,
                'customer_name' => 'João da Silva comprador',
                'customer_email' => 'joazinho_comprador@email.com',
                'customer_phone' => '11999999999',
                'customer_document' => '12345678901',
                'company_id' => 1,
            ]);
    }
}
