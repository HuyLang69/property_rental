<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;  // ← ADD THIS LINE!
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Register ───────────────────────────────────────────────

    public function showRegister()
    {
        // Redirect away if already logged in
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'terms'      => ['accepted'],
        ]);

        $user = User::create([
            'first_name' => strip_tags($request->first_name),
            'last_name'  => strip_tags($request->last_name),
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
        ]);

        // Log in immediately after registering
        Auth::login($user);

        // Regenerate session to prevent session fixation
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Welcome to NestAway, ' . $user->first_name . '!');
    }

    // ── Login ──────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Rate limiting — max 5 attempts per email per minute
        $key = 'login.' . Str::lower($request->email) . '.' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Too many login attempts. Try again in {$seconds} seconds."]);
        }

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Clear rate limiter on success
            RateLimiter::clear($key);

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Redirect to intended page or home
            return redirect()->intended(route('home'));
        }

        // Increment failed attempts
        RateLimiter::hit($key, 60);

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    // ── Logout ─────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}