<?php

namespace Database\Seeders;

use App\Domain\Records\Models\TourGuide;
use Illuminate\Database\Seeder;

class TourGuidesSeeder extends Seeder
{
    public function run()
    {
        TourGuide::factory()
            ->create([
                'id' => 1,
                'name' => 'João Guia',
                'document' => '12345678901',
                'phone' => '11988888888',
                'email' => 'jao_guia@email.com',
                'company_id' => 1,
            ]);
    }
}
