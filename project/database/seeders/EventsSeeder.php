<?php

namespace Database\Seeders;

use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Vehicle;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $vehicle = Vehicle::find(1);

        Event::factory()
            ->create([
                'id' => 1,
                'vehicle_id' => 1,
                'tour_guide_id' => 1,
                'driver_id' => 1,
                'tour_id' => 1,
                'total_seats' => $vehicle->number_of_seats,
                'available_seats' => $vehicle->number_of_seats,
                'company_id' => 1,
            ]);
    }
}
