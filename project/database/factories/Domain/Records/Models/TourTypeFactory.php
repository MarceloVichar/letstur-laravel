<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Models\TourType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourTypeFactory extends Factory
{
    protected $model = TourType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(4),
            'name' => $this->faker->word(),
            'is_exclusive' => $this->faker->boolean(),
            'is_transfer' => $this->faker->boolean(),
            'color' => $this->faker->hexColor(),
            'company_id' => Company::factory()
        ];
    }
}
