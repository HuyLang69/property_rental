<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'email'          => fake()->unique()->safeEmail(),
            'password'       => bcrypt('password'),  // all test users use "password"
            'phone'          => fake()->phoneNumber(),
            'bio'            => fake()->sentence(),
            'remember_token' => Str::random(10),
        ];
    }
}
