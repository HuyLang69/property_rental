<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Listing;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    // /host/listings — all host's listings
    public function listings()
    {
        $listings = Listing::with(['coverImage', 'bookings'])
            ->where('user_id', Auth::id())
            ->withCount('bookings')
            ->orderByDesc('created_at')
            ->get();

        return view('host.listings', compact('listings'));
    }
    // /host/dashboard — redirect to bookings
    public function index()
    {
        return redirect()->route('host.bookings');
    }

    // /host/bookings — all incoming bookings across all host's listings
    public function bookings(Request $request)
    {
        $listingIds = Listing::where('user_id', Auth::id())->pluck('id');

        $query = Booking::with(['listing', 'user'])
            ->whereIn('listing_id', $listingIds);

        // Filter by status
        $status = $request->get('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Filter by listing
        $listingFilter = $request->get('listing_id');
        if ($listingFilter) {
            $query->where('listing_id', $listingFilter);
        }

        $bookings = $query->orderByDesc('created_at')->get();

        // All listings for the filter dropdown
        $listings = Listing::where('user_id', Auth::id())
            ->orderBy('title')
            ->get();

        return view('host.bookings', compact('bookings', 'listings', 'status', 'listingFilter'));
    }

    // /host/earnings — revenue breakdown
    public function earnings()
    {
        $listings = Listing::where('user_id', Auth::id())
            ->with(['bookings' => fn($q) => $q->where('status', 'confirmed')])
            ->withCount(['bookings as confirmed_bookings_count' => fn($q) => $q->where('status', 'confirmed')])
            ->orderByDesc('created_at')
            ->get();

        // Total across all listings (confirmed only)
        $listingIds   = $listings->pluck('id');
        $totalRevenue = Booking::whereIn('listing_id', $listingIds)
            ->where('status', 'confirmed')
            ->sum('total');

        $totalBookings = Booking::whereIn('listing_id', $listingIds)
            ->where('status', 'confirmed')
            ->count();

        // Per-listing revenue
        $listingsWithRevenue = $listings->map(function ($listing) {
            $listing->revenue       = $listing->bookings->sum('total');
            $listing->booking_count = $listing->bookings->count();
            return $listing;
        })->sortByDesc('revenue');

        return view('host.earnings', compact(
            'listingsWithRevenue',
            'totalRevenue',
            'totalBookings'
        ));
    }

    // /host/reviews — reviews left on host's listings
    public function reviews()
    {
        $listingIds = Listing::where('user_id', Auth::id())->pluck('id');

        $reviews = Review::with(['listing', 'user', 'booking'])
            ->whereIn('listing_id', $listingIds)
            ->orderByDesc('created_at')
            ->get();

        $avgRating = $reviews->avg('rating');

        return view('host.reviews', compact('reviews', 'avgRating'));
    }

    // Cancel a booking on one of host's listings
    public function cancelBooking(Booking $booking)
    {
        // Must be the host of the listing
        if ($booking->listing->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }
}