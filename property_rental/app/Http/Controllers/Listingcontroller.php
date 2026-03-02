<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    // /listings — browse all with optional filters
    public function index(Request $request)
    {
        $query = Listing::with(['coverImage', 'reviews', 'host'])
            ->where('is_available', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_night', '>=', $request->price_min * 100);
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_night', '<=', $request->price_max * 100);
        }

        if ($request->filled('beds')) {
            $query->where('bedrooms', '>=', $request->beds);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price_per_night', 'asc'),
            'price_desc' => $query->orderBy('price_per_night', 'desc'),
            'rating'     => $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating'),
            default      => $query->orderBy('created_at', 'desc'),
        };

        $listings = $query->paginate(12)->withQueryString();

        return view('listings.index', compact('listings'));
    }

    // /listings/{id} — single listing
    public function show(Listing $listing)
    {
        $listing->load(['images', 'host', 'reviews.user']);

        $listing->loadAvg('reviews', 'rating');
        $listing->loadCount('reviews');

        return view('listings.show', compact('listing'));
    }
}