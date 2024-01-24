<?php

namespace Database\Factories\Domain\Sales\Models;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use App\Domain\Events\Models\Event;
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

    public function attachEvent(?int $eventId = null)
    {
        return $this->afterCreating(function (Sale $sale) use ($eventId) {
            $event = $eventId ? Event::find($eventId) : Event::factory()->create();
            $quantity = $this->faker->numberBetween(1, 3);
            $sale->events()->attach(
                $event->id,
                [
                    'quantity' => $quantity,
                    'total_value_cents' => $this->faker->randomNumber(6),
                    'passengers' => json_encode($this->generatePassengers($quantity)),
                ]
            );
        });
    }

    private function generatePassengers(int $quantity): array
    {
        $passengers = [];
        for ($i = 0; $i < $quantity; $i++) {
            $passengers[] = [
                'name' => $this->faker->name(),
                'document' => $this->faker->randomNumber(8),
            ];
        }

        return $passengers;
    }
}
