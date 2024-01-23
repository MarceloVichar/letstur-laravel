<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            CompaniesSeeder::class,
            UsersSeeder::class,
            VehiclesSeeder::class,
            DriversSeeder::class,
            TourTypesSeeder::class,
            TourGuidesSeeder::class,
            LocalesSeeder::class,
            ToursSeeder::class,
            EventsSeeder::class,
            SalesSeeder::class,
        ]);
    }
}
