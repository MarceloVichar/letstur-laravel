<?php

namespace Database\Factories\Domain\Account\Models;

use App\Domain\Account\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

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
            'trading_name' => $this->faker->name(),
            'cnpj' => $this->faker->randomNumber(8),
            'ie' => $this->faker->randomNumber(8),
            'phone' => $this->faker->phoneNumber(),
            'secondary_phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
        ];
    }
}
