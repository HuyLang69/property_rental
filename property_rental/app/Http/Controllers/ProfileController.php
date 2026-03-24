<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:150', 'unique:users,email,' . $user->id],
            'phone'      => ['nullable', 'string', 'max:30'],
            'bio'        => ['nullable', 'string', 'max:500'],
        ]);

        $user->update([
            'first_name' => strip_tags($request->first_name),
            'last_name'  => strip_tags($request->last_name),
            'email'      => $request->email,
            'phone'      => strip_tags($request->phone ?? ''),
            'bio'        => strip_tags($request->bio ?? ''),
        ]);

        return back()->with('success', 'Profile updated.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }
}