<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'booking_id'  => 1,  // overridden in seeder
            'user_id'     => 1,  // overridden in seeder
            'listing_id'  => 1,  // overridden in seeder
            'rating'      => fake()->numberBetween(3, 5), // bias toward positive reviews
            'comment'     => fake()->paragraph(),
        ];
    }
}
