<?php

namespace Database\Factories\Domain\Account\Models;

use App\Domain\Account\Enums\RoleEnum;
use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Account\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

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
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(RoleEnum::ADMIN);
        });
    }

    public function companyAdmin($companyId = null)
    {
        return $this->afterCreating(function (User $user) use ($companyId) {
            $user->assignRole(RoleEnum::COMPANY_ADMIN);
            $user->company_id = $companyId ?? Company::factory()->create()->id;
            $user->save();
        });
    }

    public function companyOperator($companyId = null)
    {
        return $this->afterCreating(function (User $user) use ($companyId) {
            $user->assignRole(RoleEnum::COMPANY_OPERATOR);
            $user->company_id = $companyId ?? Company::factory()->create()->id;
            $user->save();
        });
    }
}
