<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $listings = Listing::all();
        $users    = User::all();

        // Each listing gets 2–4 bookings from random other users
        $listings->each(function (Listing $listing) use ($users) {
            $count = rand(2, 4);

            for ($i = 0; $i < $count; $i++) {
                // Guest must be a different user than the host
                $guest = $users->where('id', '!=', $listing->user_id)->random();

                Booking::factory()->create([
                    'user_id'    => $guest->id,
                    'listing_id' => $listing->id,
                ]);
            }
        });
    }
}
