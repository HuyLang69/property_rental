<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'city',
        'country',
        'address',
        'bedrooms',
        'bathrooms',
        'max_guests',
        'price_per_night',
        'cleaning_fee',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    // The host
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(ListingImage::class)->orderBy('order');
    }

    public function coverImage()
    {
        return $this->hasOne(ListingImage::class)->where('is_cover', true);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    // Returns price in dollars for display, e.g. 8500 → 85.00
    public function getPriceAttribute(): string
    {
        return number_format($this->price_per_night / 100, 2);
    }

    // Average rating rounded to 1 decimal
    public function getAverageRatingAttribute(): ?string
    {
        $avg = $this->reviews()->avg('rating');
        return $avg ? number_format($avg, 1) : null;
    }

    // Scope: only available listings
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // Scope: filter by type
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}