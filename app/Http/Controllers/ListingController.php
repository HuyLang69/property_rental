<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    // ── Public: browse all listings ────────────────────────────
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
        if ($sort === 'price_asc') {
            $query->orderBy('price_per_night', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price_per_night', 'desc');
        } elseif ($sort === 'rating') {
            $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $listings = $query->paginate(12)->withQueryString();

        return view('listings.index', compact('listings'));
    }

    // ── Public: single listing detail ──────────────────────────
    public function show(Listing $listing)
    {
        $listing->load(['images', 'host', 'reviews.user']);
        $listing->loadAvg('reviews', 'rating');
        $listing->loadCount('reviews');

        return view('listings.show', compact('listing'));
    }

    // ── Host: show create form ──────────────────────────────────
    public function create()
    {
        return view('listings.create');
    }

    // ── Host: save new listing ─────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:150',
            'type'            => 'required|in:apartment,house,studio,villa,room',
            'description'     => 'required|string|max:3000',
            'city'            => 'required|string|max:100',
            'country'         => 'required|string|max:100',
            'address'         => 'required|string|max:255',
            'bedrooms'        => 'required|integer|min:0|max:50',
            'bathrooms'       => 'required|integer|min:0|max:50',
            'max_guests'      => 'required|integer|min:1|max:50',
            'price_per_night' => 'required|numeric|min:1|max:99999',
            'cleaning_fee'    => 'nullable|numeric|min:0|max:9999',
            'images'          => 'required|array|min:1|max:10',
            'images.*'        => 'required|file|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $listing = Listing::create([
            'user_id'         => Auth::id(),
            'title'           => strip_tags($data['title']),
            'type'            => $data['type'],
            'description'     => strip_tags($data['description']),
            'city'            => strip_tags($data['city']),
            'country'         => strip_tags($data['country']),
            'address'         => strip_tags($data['address']),
            'bedrooms'        => $data['bedrooms'],
            'bathrooms'       => $data['bathrooms'],
            'max_guests'      => $data['max_guests'],
            'price_per_night' => (int) round($data['price_per_night'] * 100),
            'cleaning_fee'    => (int) round(($data['cleaning_fee'] ?? 0) * 100),
            'is_available'    => $request->boolean('is_available'),
        ]);

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store("listings/{$listing->id}", 'public');
            ListingImage::create([
                'listing_id' => $listing->id,
                'path'       => $path,
                'is_cover'   => $index === 0,
                'order'      => $index,
            ]);
        }

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Your listing has been published!');
    }

    // ── Host: show edit form ────────────────────────────────────
    public function edit(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $listing->load('images');

        return view('listings.edit', compact('listing'));
    }

    // ── Host: update listing ───────────────────────────────────
    public function update(Request $request, Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'title'           => 'required|string|max:150',
            'type'            => 'required|in:apartment,house,studio,villa,room',
            'description'     => 'required|string|max:3000',
            'city'            => 'required|string|max:100',
            'country'         => 'required|string|max:100',
            'address'         => 'required|string|max:255',
            'bedrooms'        => 'required|integer|min:0|max:50',
            'bathrooms'       => 'required|integer|min:0|max:50',
            'max_guests'      => 'required|integer|min:1|max:50',
            'price_per_night' => 'required|numeric|min:1|max:99999',
            'cleaning_fee'    => 'nullable|numeric|min:0|max:9999',
            'images'          => 'nullable|array|min:1|max:10',
            'images.*'        => 'required|file|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        // Delete images marked for removal
        if ($request->filled('delete_images')) {
            $toDelete = ListingImage::where('listing_id', $listing->id)
                ->whereIn('id', $request->delete_images)
                ->get();

            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
        }

        // Upload new images
        if ($request->hasFile('images')) {
            // Determine next order value
            $maxOrder = $listing->images()->max('order') ?? -1;

            // If the listing has no remaining cover, the first new image becomes cover
            $hasCover = $listing->images()->where('is_cover', true)->exists();

            foreach ($request->file('images') as $index => $file) {
                $path = $file->store("listings/{$listing->id}", 'public');
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'path'       => $path,
                    'is_cover'   => !$hasCover && $index === 0,
                    'order'      => $maxOrder + $index + 1,
                ]);
                $hasCover = true; // only first can be cover
            }
        }

        $listing->update([
            'title'           => strip_tags($data['title']),
            'type'            => $data['type'],
            'description'     => strip_tags($data['description']),
            'city'            => strip_tags($data['city']),
            'country'         => strip_tags($data['country']),
            'address'         => strip_tags($data['address']),
            'bedrooms'        => $data['bedrooms'],
            'bathrooms'       => $data['bathrooms'],
            'max_guests'      => $data['max_guests'],
            'price_per_night' => (int) round($data['price_per_night'] * 100),
            'cleaning_fee'    => (int) round(($data['cleaning_fee'] ?? 0) * 100),
            'is_available'    => $request->boolean('is_available'),
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully.');
    }

    // ── Host: delete listing ───────────────────────────────────
    public function destroy(Listing $listing)
    {
        if ($listing->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete all images from storage
        foreach ($listing->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $listing->delete();

        return redirect()->route('host.listings')
            ->with('success', 'Listing deleted.');
    }
}