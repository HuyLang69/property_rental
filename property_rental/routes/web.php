<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
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

// ── Listings ───────────────────────────────────────────────────
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// ── Auth ───────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');