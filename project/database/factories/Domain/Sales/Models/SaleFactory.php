<?php

namespace Database\Factories\Domain\Sales\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Sales\Enums\SaleStatusEnum;
use App\Domain\Sales\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $companyId = Company::factory()->create()->id;

        return [
            'id' => $this->faker->unique()->randomNumber(4),
            'total_value_cents' => $this->faker->randomNumber(6),
            'status' => $this->faker->randomElement(SaleStatusEnum::getConstantsValues()),
            'voucher' => $this->faker->text('10'),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_document' => $this->faker->randomNumber(8),
            'company_id' => $companyId,
            'seller_id' => User::factory()
                ->companyOperator($companyId)
                ->create()
                ->id,
        ];
    }
}
