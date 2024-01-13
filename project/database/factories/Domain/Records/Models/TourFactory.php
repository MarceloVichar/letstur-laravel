<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\Locale;
use App\Domain\Records\Models\Tour;
use App\Domain\Records\Models\TourType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(4),
            'name' => $this->faker->name(),
            'round_trip' => $this->faker->randomNumber(3),
            'price_cents' => $this->faker->randomNumber(5),
            'note' => $this->faker->text(100),
            'locale_id' => Locale::factory(),
            'tour_type_id' => TourType::factory(),
            'company_id' => Company::factory()
        ];
    }
}
