<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\TourGuide;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourGuideFactory extends Factory
{
    protected $model = TourGuide::class;

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
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'document' => $this->faker->randomNumber(),
            'company_id' => Company::factory(),
        ];
    }
}
