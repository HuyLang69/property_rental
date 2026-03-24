<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'phone',
        'bio',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    // Listings this user hosts
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    // Bookings this user made as a guest
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Reviews this user has written
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}