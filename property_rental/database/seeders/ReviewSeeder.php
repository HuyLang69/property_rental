<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Only confirmed bookings can have a review, and not all of them do
        $bookings = Booking::where('status', 'confirmed')->get();

        $bookings->each(function (Booking $booking) {
            // 70% chance the guest left a review
            if (rand(1, 10) <= 7) {
                Review::factory()->create([
                    'booking_id' => $booking->id,
                    'user_id'    => $booking->user_id,
                    'listing_id' => $booking->listing_id,
                ]);
            }
        });
    }
}
