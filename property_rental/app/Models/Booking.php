<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listing_id',
        'check_in',
        'check_out',
        'guests',
        'price_per_night',
        'cleaning_fee',
        'service_fee',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'check_in'  => 'date',
            'check_out' => 'date',
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    // The guest who made the booking
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getTotalInDollarsAttribute(): string
    {
        return number_format($this->total / 100, 2);
    }

    public function hasReview(): bool
    {
        return $this->review()->exists();
    }

    // Scope: only confirmed bookings
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}