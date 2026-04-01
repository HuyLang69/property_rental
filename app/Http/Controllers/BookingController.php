<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Show the payment page — receives listing + dates from the listing show form
    public function create(Request $request)
    {
        $request->validate([
            'listing_id' => ['required', 'exists:listings,id'],
            'check_in'   => ['required', 'date', 'after_or_equal:today'],
            'check_out'  => ['required', 'date', 'after:check_in'],
            'guests'     => ['required', 'integer', 'min:1'],
        ]);

        $listing = Listing::with('coverImage')->findOrFail($request->listing_id);

        // Can't book your own listing
        if ($listing->user_id === Auth::id()) {
            return back()->withErrors(['listing_id' => 'You cannot book your own listing.']);
        }

        // Respect max guests
        if ($request->guests > $listing->max_guests) {
            return back()->withErrors(['guests' => "Max {$listing->max_guests} guests allowed."]);
        }

        // Only confirmed bookings block dates — pending bookings don't hold the slot
        // Proper overlap detection: existing.check_in < new.check_out AND existing.check_out > new.check_in
        $conflict = Booking::where('listing_id', $listing->id)
            ->where('status', 'confirmed')
            ->where(function ($q) use ($request) {
                $q->where('check_in', '<', $request->check_out)
                  ->where('check_out', '>', $request->check_in);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['check_in' => 'These dates are already booked. Please choose different dates.']);
        }

        $checkIn    = Carbon::parse($request->check_in);
        $checkOut   = Carbon::parse($request->check_out);
        $nights     = $checkIn->diffInDays($checkOut);
        $serviceFee = (int) ($listing->price_per_night * $nights * 0.12);
        $total      = ($listing->price_per_night * $nights) + $listing->cleaning_fee + $serviceFee;

        return view('billing.payment', [
            'listing'    => $listing,
            'checkIn'    => $request->check_in,
            'checkOut'   => $request->check_out,
            'guests'     => $request->guests,
            'nights'     => $nights,
            'serviceFee' => $serviceFee,
            'total'      => $total,
        ]);
    }

    // Store the booking after payment form submitted
    public function store(Request $request)
    {
        $request->validate([
            'listing_id'      => ['required', 'exists:listings,id'],
            'check_in'        => ['required', 'date', 'after_or_equal:today'],
            'check_out'       => ['required', 'date', 'after:check_in'],
            'guests'          => ['required', 'integer', 'min:1'],

            // Card — format validation only, nothing is stored
            'cardholder_name' => ['required', 'string', 'max:100'],
            'card_number'     => ['required', 'string', 'regex:/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/'],
            'expiry'          => ['required', 'string', 'regex:/^\d{2}\s\/\s\d{2}$/'],
            'cvv'             => ['required', 'string', 'digits_between:3,4'],

            // Billing address
            'billing_name'    => ['required', 'string', 'max:100'],
            'billing_address' => ['required', 'string', 'max:255'],
            'billing_city'    => ['required', 'string', 'max:100'],
            'billing_zip'     => ['required', 'string', 'max:20'],
            'billing_country' => ['required', 'string', 'max:2'],
        ]);

        $listing = Listing::findOrFail($request->listing_id);

        // Re-run all security checks server-side — never trust the client
        if ($listing->user_id === Auth::id()) {
            return back()->withErrors(['listing_id' => 'You cannot book your own listing.']);
        }

        if ($request->guests > $listing->max_guests) {
            return back()->withErrors(['guests' => "Max {$listing->max_guests} guests allowed."]);
        }

        // Only confirmed bookings block dates — pending bookings don't hold the slot
        // Proper overlap detection: existing.check_in < new.check_out AND existing.check_out > new.check_in
        $conflict = Booking::where('listing_id', $listing->id)
            ->where('status', 'confirmed')
            ->where(function ($q) use ($request) {
                $q->where('check_in', '<', $request->check_out)
                  ->where('check_out', '>', $request->check_in);
            })->exists();

        if ($conflict) {
            return back()->withErrors(['check_in' => 'These dates are already booked.']);
        }

        $checkIn       = Carbon::parse($request->check_in);
        $checkOut      = Carbon::parse($request->check_out);
        $nights        = $checkIn->diffInDays($checkOut);
        $pricePerNight = $listing->price_per_night;
        $cleaningFee   = $listing->cleaning_fee;
        $serviceFee    = (int) ($pricePerNight * $nights * 0.12);
        $total         = ($pricePerNight * $nights) + $cleaningFee + $serviceFee;

        // Card details are intentionally NEVER stored
        $booking = Booking::create([
            'user_id'         => Auth::id(),
            'listing_id'      => $listing->id,
            'check_in'        => $request->check_in,
            'check_out'       => $request->check_out,
            'guests'          => $request->guests,
            'price_per_night' => $pricePerNight,
            'cleaning_fee'    => $cleaningFee,
            'service_fee'     => $serviceFee,
            'total'           => $total,
            'status'          => 'confirmed',
        ]);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking confirmed! Enjoy your stay.');
    }

    // Booking confirmation page
    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && $booking->listing->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['listing.coverImage', 'listing.host']);

        return view('bookings.show', compact('booking'));
    }

    // Cancel a booking
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('dashboard.bookings')
            ->with('success', 'Your booking has been cancelled.');
    }
}