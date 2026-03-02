<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'listing_id',
        'path',
        'is_cover',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'is_cover' => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    // ── Helpers ────────────────────────────────────────────────

    // Returns the full public URL for use in <img src="">
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}