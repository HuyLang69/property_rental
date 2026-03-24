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
        $filter = request('filter', 'upcoming');
        
        $query = Booking::with(['listing.coverImage'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at');

        if ($filter === 'upcoming') {
            $query->where('status', '!=', 'cancelled')->where('check_out', '>', now());
        } elseif ($filter === 'past') {
            $query->where('status', 'confirmed')->where('check_out', '<=', now());
        } elseif ($filter === 'cancelled') {
            $query->where('status', 'cancelled');
        }

        $bookings = $query->paginate(10)->withQueryString();

        $counts = [
            'upcoming' => Booking::where('user_id', Auth::id())->where('status', '!=', 'cancelled')->where('check_out', '>', now())->count(),
            'past' => Booking::where('user_id', Auth::id())->where('status', 'confirmed')->where('check_out', '<=', now())->count(),
            'cancelled' => Booking::where('user_id', Auth::id())->where('status', 'cancelled')->count(),
            'all' => Booking::where('user_id', Auth::id())->count(),
        ];

        return view('dashboard.bookings', compact('bookings', 'filter', 'counts'));
    }


}