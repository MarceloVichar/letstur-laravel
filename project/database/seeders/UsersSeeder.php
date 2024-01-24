<?php

namespace Database\Seeders;

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
        $users = [
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'type' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'Company admin',
                'email' => 'company_admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'company_id' => 1,
                'type' => 'companyAdmin'
            ],
            [
                'id' => 3,
                'name' => 'Company operator',
                'email' => 'company_operator@letsgrow.com.br',
                'password' => Hash::make('12345678'),
                'company_id' => 1,
                'type' => 'companyOperator'
            ]
        ];

        foreach ($users as $user) {
            if (!User::find($user['id'])) {
                User::factory()
                    ->{$user['type']}($user['company_id'] ?? null)
                    ->create([
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => $user['password'],
                    ]);
            }
        }
    }
}
