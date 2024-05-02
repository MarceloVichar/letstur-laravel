<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\Locale;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourType;
use Illuminate\Database\Seeder;

class ToursSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;
        $tour_type_id = TourType::query()->first()->id;
        $locale_id = Locale::query()->first()->id;

        Tour::factory()
            ->create([
                'name' => 'Passeio na pracinha central',
                'round_trip' => 20,
                'price_cents' => 10000,
                'locale_id' => $locale_id,
                'tour_type_id' => $tour_type_id,
                'company_id' => $company_id,
            ]);
    }
}
