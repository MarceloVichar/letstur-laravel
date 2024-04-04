<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Events\Models\Event;
use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;
        $event_id = Event::query()->first()->id;
        $seller_id = User::query('role', 'company_operator')->first()->id;

        Sale::factory()
            ->attachEvent($event_id)
            ->create([
                'status' => SaleStatusEnum::PENDING,
                'seller_id' => $seller_id,
                'customer_name' => 'João da Silva comprador',
                'customer_email' => 'joazinho_comprador@email.com',
                'customer_phone' => '11999999999',
                'customer_document' => '12345678901',
                'company_id' => $company_id,
            ]);
    }
}
