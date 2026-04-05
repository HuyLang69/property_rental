<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // One known user so you can always log in during development
        User::create([
            'first_name' => 'Test',
            'last_name'  => 'User',
            'email'      => 'test@test.com',
            'password'   => bcrypt('password'),
            'bio'        => 'I am the test user.',
            'is_admin'   => true,  // ← ADD THIS LINE!
        ]);

        // 9 additional random users
        User::factory(9)->create();
    }
}