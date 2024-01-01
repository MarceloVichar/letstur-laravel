<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()
            ->admin()
            ->create([
                'name' => 'Admin',
                'email' => 'admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
            ]);

        User::factory()
            ->company_admin()
            ->create([
                'name' => 'Company admin',
                'email' => 'company_admin@letsgrow.com.br',
                'password' => Hash::make('12345678'),
            ]);

        User::factory()
            ->company_operator()
            ->create([
                'name' => 'Company operator',
                'email' => 'company_operator@letsgrow.com.br',
                'password' => Hash::make('12345678'),
            ]);
    }
}
