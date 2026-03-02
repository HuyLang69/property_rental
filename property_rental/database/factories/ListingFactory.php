<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ListingFactory extends Factory
{
    public function definition(): array
    {
        $types = ['apartment', 'house', 'studio', 'villa', 'room'];

        $cities = [
            ['city' => 'Lisbon',   'country' => 'Portugal'],
            ['city' => 'Porto',    'country' => 'Portugal'],
            ['city' => 'Lagos',    'country' => 'Portugal'],
            ['city' => 'Sintra',   'country' => 'Portugal'],
            ['city' => 'Cascais',  'country' => 'Portugal'],
            ['city' => 'Sesimbra', 'country' => 'Portugal'],
            ['city' => 'Alentejo', 'country' => 'Portugal'],
            ['city' => 'Óbidos',   'country' => 'Portugal'],
        ];

        $location = fake()->randomElement($cities);

        return [
            'user_id'         => 1,  // overridden in seeder
            'title'           => fake()->sentence(4),
            'description'     => fake()->paragraphs(3, true),
            'type'            => fake()->randomElement($types),
            'city'            => $location['city'],
            'country'         => $location['country'],
            'address'         => fake()->streetAddress(),
            'bedrooms'        => fake()->numberBetween(1, 5),
            'bathrooms'       => fake()->numberBetween(1, 3),
            'max_guests'      => fake()->numberBetween(1, 8),
            'price_per_night' => fake()->numberBetween(3000, 30000), // cents: $30–$300
            'cleaning_fee'    => fake()->numberBetween(1000, 5000),  // cents: $10–$50
            'is_available'    => true,
        ];
    }
}
