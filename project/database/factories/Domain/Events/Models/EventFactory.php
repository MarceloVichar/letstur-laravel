<?php

namespace Database\Factories\Domain\Events\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Events\Models\Event;
use App\Domain\Records\Models\Driver;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourGuide;
use App\Domain\Records\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalSeats = $this->faker->randomNumber(2);
        $departureDateTime = $this->faker->dateTimeBetween('now', '+2 days');
        $arrivalDateTime = (clone $departureDateTime)->modify('+3 hours');

        return [
            'id' => $this->faker->unique()->randomNumber(4),
            'total_seats' => $totalSeats,
            'available_seats' => $totalSeats,
            'departure_date_time' => $departureDateTime,
            'arrival_date_time' => $arrivalDateTime,
            'tour_guide_id' => TourGuide::factory(),
            'vehicle_id' => Vehicle::factory(),
            'tour_id' => Tour::factory(),
            'driver_id' => Driver::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
