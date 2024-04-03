<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourGuide;
use App\Domain\Records\Models\Vehicle;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $company_id = Company::query()->first()->id;
        $tour_guide_id = TourGuide::query()->first()->id;
        $driver_id = Driver::query()->first()->id;
        $tour_id = Tour::query()->first()->id;
        $vehicle = Vehicle::query()->first();

        Event::factory()
            ->create([
                'vehicle_id' => $vehicle->id,
                'tour_guide_id' => $tour_guide_id,
                'driver_id' => $driver_id,
                'tour_id' => $tour_id,
                'total_seats' => $vehicle->number_of_seats,
                'available_seats' => $vehicle->number_of_seats,
                'company_id' => $company_id,
            ]);
    }
}
