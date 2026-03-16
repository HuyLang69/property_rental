<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard.bookings');
    }

    public function bookings()
    {
        $bookings = Booking::with(['listing.coverImage'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.bookings', compact('bookings'));
    }

    public function listings()
    {
        $listings = Listing::with(['coverImage', 'bookings'])
            ->where('user_id', Auth::id())
            ->withCount('bookings')
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.listings', compact('listings'));
    }
}