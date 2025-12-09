<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();

        // Find user by email
        $user = User::where('personalEmail', $googleUser->getEmail())->first();

        // If user does not exist, redirect with custom message
        if (!$user) {
            return redirect('/register')
                ->with('error', 'No account found for this Google email. Please sign up first.');
        }

        // Login existing user
        Auth::login($user);

        return redirect('/dashboard');
    } catch (\Exception $e) {
        \Log::error('Google Login Error: ' . $e->getMessage());
        return redirect('/login')->with('error', 'Google login failed. Please try again.');
    }
}

}
