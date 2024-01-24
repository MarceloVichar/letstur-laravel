<?php

namespace Database\Seeders;

use App\Domain\Records\Models\Tour;
use Illuminate\Database\Seeder;

class ToursSeeder extends Seeder
{
    public function run()
    {
        Tour::factory()
            ->create([
                'id' => 1,
                'name' => 'Passeio na pracinha central',
                'round_trip' => 20,
                'price_cents' => 10000,
                'locale_id' => 1,
                'tour_type_id' => 1,
                'company_id' => 1,
            ]);
    }
}
