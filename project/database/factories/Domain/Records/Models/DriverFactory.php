<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

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
            'cnh' => $this->faker->randomNumber(8),
            'cnh_type' => $this->faker->randomElement(CnhTypesEnum::getConstantsValues()),
            'document' => $this->faker->randomNumber(8),
            'phone' => $this->faker->phoneNumber(),
            'date_of_birth' => $this->faker->dateTime(),
            'email' => $this->faker->safeEmail(),
            'company_id' => Company::factory(),
        ];
    }
}
