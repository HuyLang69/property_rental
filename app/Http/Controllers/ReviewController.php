<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Show the review form for a completed booking
    public function create(Booking $booking)
    {
        // Only the guest can review
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Booking must be confirmed
        if ($booking->status !== 'confirmed') {
            return redirect()->route('dashboard.bookings')
                ->with('error', 'You can only review confirmed bookings.');
        }

        // Booking must be in the past
        if ($booking->check_out->isFuture()) {
            return redirect()->route('dashboard.bookings')
                ->with('error', 'You can only review a stay after check-out.');
        }

        // Can't review twice
        if ($booking->hasReview()) {
            return redirect()->route('dashboard.bookings')
                ->with('error', 'You have already reviewed this stay.');
        }

        $booking->load('listing.coverImage');

        return view('reviews.create', compact('booking'));
    }

    // Store the review
    public function store(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        // Re-check server side
        if ($booking->status !== 'confirmed') {
            abort(403);
        }

        if ($booking->check_out->isFuture()) {
            abort(403);
        }

        if ($booking->hasReview()) {
            return redirect()->route('dashboard.bookings')
                ->with('error', 'You have already reviewed this stay.');
        }

        Review::create([
            'booking_id' => $booking->id,
            'user_id'    => Auth::id(),
            'listing_id' => $booking->listing_id,
            'rating'     => $request->rating,
            'comment'    => strip_tags($request->comment),
        ]);

        return redirect()->route('dashboard.bookings')
            ->with('success', 'Review submitted. Thanks for your feedback!');
    }
}