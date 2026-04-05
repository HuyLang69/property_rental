<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'User',
            'name'       => 'Admin User',
            'email'      => 'admin@nestaway.com',
            'password'   => Hash::make('AdminPass123!'),
            'is_admin'   => true,
            'email_verified_at' => now(),
        ]);

        // Regular test user
        User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@test.com',
            'password'   => bcrypt('password'),
            'bio'        => 'I am the test user.',
            'is_admin'   => false,
        ]);

        // 9 additional random users
        User::factory(9)->create();
    }
}