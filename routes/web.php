<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// ── Fresh Migrations (TEMPORARY - DELETE AFTER USE) ──
Route::get('/fresh-migrations', function () {
    if (request()->get('token') !== env('MIGRATION_TOKEN')) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    try {
        // Drop all tables and re-migrate
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        
        return response()->json([
            'message' => '✅ Database reset complete! All tables recreated.',
            'output' => \Illuminate\Support\Facades\Artisan::output()
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->withoutMiddleware(['web', 'auth']);
// ── Health Check for Railway (MUST bypass middleware) ──
Route::get('/health', function () {
    return response('OK', 200)
        ->header('Content-Type', 'text/plain');
})->withoutMiddleware(['web', 'auth']);
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

// ── Static Pages ───────────────────────────────────────────────
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// ── Listings (public) ──────────────────────────────────────────
Route::get('/listings',           [ListingController::class, 'index'])->name('listings.index');
// create MUST be before {listing} wildcard or Laravel will try to bind 'create' as an ID
Route::get('/listings/create',    [ListingController::class, 'create'])->name('listings.create')->middleware('auth');
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

// ── Auth required ──────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // ── Guest dashboard ────────────────────────────────────────
    Route::get('/dashboard',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/trips',    [DashboardController::class, 'bookings'])->name('dashboard.bookings');

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
    Route::get('/host',                              [HostController::class, 'index'])->name('host.dashboard');
    Route::get('/host/listings',                     [HostController::class, 'listings'])->name('host.listings');
    Route::get('/host/bookings',                     [HostController::class, 'bookings'])->name('host.bookings');
    Route::get('/host/earnings',                     [HostController::class, 'earnings'])->name('host.earnings');
    Route::get('/host/reviews',                      [HostController::class, 'reviews'])->name('host.reviews');
    Route::patch('/host/bookings/{booking}/cancel',  [HostController::class, 'cancelBooking'])->name('host.cancel');

    // ── Listings host CRUD ─────────────────────────────────────────
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

// ── Admin Dashboard ────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('destroyUser');
    Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
    Route::patch('/listings/{listing}/toggle', [AdminController::class, 'toggleListing'])->name('toggleListing');
    Route::delete('/listings/{listing}', [AdminController::class, 'destroyListing'])->name('destroyListing');
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
});



Route::get('/run-migrations', function () {
    // Only allow this in production if you add a secret token
    if (request()->get('token') !== env('MIGRATION_TOKEN')) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }
    
    try {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('storage:link');
        return response()->json([
            'message' => 'Migrations completed!',
            'output' => Artisan::output()
        ], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
