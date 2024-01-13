<?php

namespace Database\Factories\Domain\Records\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Records\Enums\CnhTypesEnum;
use App\Domain\Records\Enums\VehicleTypeEnum;
use App\Domain\Records\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(4),
            'license_plate' => $this->faker->text('8'),
            'type' => $this->faker->randomElement(VehicleTypeEnum::getConstantsValues()),
            'model' => $this->faker->text('10'),
            'number_of_seats' => $this->faker->randomNumber(2),
            'cnh_type_required' => $this->faker->randomElement(CnhTypesEnum::getConstantsValues()),
            'owner_name' => $this->faker->name(),
            'owner_document' => $this->faker->randomNumber(9),
            'owner_phone' => $this->faker->phoneNumber(),
            'owner_email' => $this->faker->email(),
            'company_id' => Company::factory()
        ];
    }
}
