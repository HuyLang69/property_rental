<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $checkIn  = fake()->dateTimeBetween('-3 months', '+1 month');
        $checkOut = fake()->dateTimeBetween($checkIn, '+2 months');

        $nights      = max(1, (int) $checkIn->diff($checkOut)->days);
        $pricePerNight = fake()->numberBetween(3000, 20000);
        $cleaningFee   = fake()->numberBetween(1000, 4000);
        $serviceFee    = (int) ($pricePerNight * $nights * 0.12); // 12% service fee
        $total         = ($pricePerNight * $nights) + $cleaningFee + $serviceFee;

        return [
            'user_id'         => 1,  // overridden in seeder
            'listing_id'      => 1,  // overridden in seeder
            'check_in'        => $checkIn->format('Y-m-d'),
            'check_out'       => $checkOut->format('Y-m-d'),
            'guests'          => fake()->numberBetween(1, 4),
            'price_per_night' => $pricePerNight,
            'cleaning_fee'    => $cleaningFee,
            'service_fee'     => $serviceFee,
            'total'           => $total,
            'status'          => fake()->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
