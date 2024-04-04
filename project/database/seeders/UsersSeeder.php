<?php

namespace Database\Seeders;

use App\Domain\Account\Models\Company;
use App\Domain\Account\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company_id = Company::query()->first()->id;

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'type' => 'admin'
            ],
            [
                'name' => 'Company admin',
                'email' => 'company_admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'company_id' => $company_id,
                'type' => 'companyAdmin'
            ],
            [
                'name' => 'Company operator',
                'email' => 'company_operator@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'company_id' => $company_id,
                'type' => 'companyOperator'
            ]
        ];

        foreach ($users as $user) {
            User::factory()
                ->{$user['type']}($user['company_id'] ?? null)
                ->create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                ]);
        }
    }
}
