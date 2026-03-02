<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    // Unsplash image URLs for realistic seeded data
    // In production these would be uploaded files stored in storage/
    private array $images = [
        'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80',
        'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
        'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=800&q=80',
        'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=800&q=80',
        'https://images.unsplash.com/photo-1505691723518-36a5ac3be353?w=800&q=80',
        'https://images.unsplash.com/photo-1449844908441-8829872d2607?w=800&q=80',
        'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
        'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=800&q=80',
        'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=800&q=80',
        'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&q=80',
        'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=800&q=80',
        'https://images.unsplash.com/photo-1462275646964-a0e3386b89fa?w=800&q=80',
    ];

    public function run(): void
    {
        $users = User::all();

        // Each user gets 2–3 listings
        $users->each(function (User $user) {
            $count = rand(2, 3);

            Listing::factory($count)->create(['user_id' => $user->id])
                ->each(function (Listing $listing) {
                    // Assign 3 images per listing, first one is the cover
                    $images = collect($this->images)->shuffle()->take(3);

                    $images->each(function (string $url, int $index) use ($listing) {
                        ListingImage::create([
                            'listing_id' => $listing->id,
                            'path'       => $url,   // using URL directly for dev; swap for storage path in prod
                            'is_cover'   => $index === 0,
                            'order'      => $index,
                        ]);
                    });
                });
        });
    }
}
