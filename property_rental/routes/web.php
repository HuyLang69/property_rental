<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// ── Home ───────────────────────────────────────────────────────
Route::get('/', function () {
    $featured = \App\Models\Listing::with(['coverImage', 'reviews'])
        ->where('is_available', true)
        ->withAvg('reviews', 'rating')
        ->orderByDesc('reviews_avg_rating')
        ->take(6)
        ->get();

    $recent = \App\Models\Listing::with(['coverImage'])
        ->where('is_available', true)
        ->orderByDesc('created_at')
        ->take(4)
        ->get();

    return view('home', compact('featured', 'recent'));
})->name('home');

// ── Listings (public) ──────────────────────────────────────────
Route::get('/listings',           [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// ── Auth required ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // ── Guest dashboard ────────────────────────────────────────
    Route::get('/dashboard',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/trips',    [DashboardController::class, 'bookings'])->name('dashboard.bookings');
    Route::get('/dashboard/listings', [DashboardController::class, 'listings'])->name('dashboard.listings');

    // ── Bookings ───────────────────────────────────────────────
    Route::get('/bookings/create',             [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings',                   [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}',          [BookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    // ── Reviews ────────────────────────────────────────────────
    Route::get('/bookings/{booking}/review',  [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // ── Profile ────────────────────────────────────────────────
    Route::get('/profile',          [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // ── Host dashboard ─────────────────────────────────────────
    Route::get('/host/dashboard',                    [HostController::class, 'index'])->name('host.dashboard');
    Route::get('/host/bookings',                     [HostController::class, 'bookings'])->name('host.bookings');
    Route::get('/host/earnings',                     [HostController::class, 'earnings'])->name('host.earnings');
    Route::get('/host/reviews',                      [HostController::class, 'reviews'])->name('host.reviews');
    Route::patch('/host/bookings/{booking}/cancel',  [HostController::class, 'cancelBooking'])->name('host.cancel');

    // ── Listings host CRUD (create before {listing} wildcard) ──
    Route::get('/listings/create',         [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings',               [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/listings/{listing}',      [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/listings/{listing}',   [ListingController::class, 'destroy'])->name('listings.destroy');

});

// ── Auth ───────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');