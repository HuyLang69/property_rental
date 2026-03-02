<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ListingSeeder::class,
            BookingSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
