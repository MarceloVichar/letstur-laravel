<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Models\Locale;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocaleFactory extends Factory
{
    protected $model = Locale::class;

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
            'zip_code' => $this->faker->postcode(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->randomNumber(4),
            'complement' => $this->faker->realTextBetween(10, 20),
            'district' => $this->faker->word(),
            'city' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'responsible_name' => $this->faker->name(),
            'responsible_phone' => $this->faker->phoneNumber(),
            'company_id' => Company::factory(),
        ];
    }
}
