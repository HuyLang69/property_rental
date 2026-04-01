<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Listing;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ── Admin: Dashboard ──────────────────────────────────────────────────
    public function index()
    {
        $stats = [
            'users'    => User::count(),
            'listings' => Listing::count(),
            'bookings' => Booking::count(),
            'revenue'  => Booking::where('status', 'confirmed')->sum('total'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ── Admin: Users Management ──────────────────────────────────────────
    public function users()
    {
        $users = User::orderByDesc('created_at')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function destroyUser(User $user)
    {
        // Don't allow an admin to delete themselves to prevent locking out
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

    // ── Admin: Listings Management ───────────────────────────────────────
    public function listings()
    {
        $listings = Listing::with('host', 'coverImage')->orderByDesc('created_at')->paginate(20);
        return view('admin.listings', compact('listings'));
    }

    public function toggleListing(Listing $listing)
    {
        $listing->update([
            'is_available' => !$listing->is_available
        ]);

        return back()->with('success', 'Listing status updated.');
    }

    public function destroyListing(Listing $listing)
    {
        foreach ($listing->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $listing->delete();

        return back()->with('success', 'Listing deleted.');
    }

    // ── Admin: Bookings Management ───────────────────────────────────────
    public function bookings()
    {
        $bookings = Booking::with(['guest', 'listing'])->orderByDesc('created_at')->paginate(20);
        return view('admin.bookings', compact('bookings'));
    }
}
