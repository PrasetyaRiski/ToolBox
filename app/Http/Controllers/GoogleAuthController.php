<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke Google untuk login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect ke Google untuk register
     */
    public function redirectToGoogleRegister()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal terhubung dengan Google');
        }

        // Cek apakah user sudah ada
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // User sudah terdaftar, langsung login
            $user->update([
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($user, true);
            return redirect()->route('home');
        }

        // Cek apakah email sudah terdaftar dengan metode lain
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Email sudah terdaftar, tapi belum dengan Google
            // Link akun Google ke akun yang sudah ada
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($existingUser, true);
            return redirect()->route('home')->with('success', 'Akun Google berhasil dihubungkan');
        }

        // Buat user baru
        $newUser = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'password' => null, // Password tidak perlu untuk OAuth
        ]);

        Auth::login($newUser, true);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat dengan Google');
    }

    /**
     * Link Google ke akun yang sudah ada (untuk logged in users)
     */
    public function linkGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle linking Google ke akun existing
     */
    public function handleLinkGoogleCallback()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung dengan Google');
        }

        // Cek apakah Google ID sudah digunakan user lain
        $existingGoogle = User::where('google_id', $googleUser->getId())
            ->where('id', '!=', Auth::id())
            ->first();

        if ($existingGoogle) {
            return back()->with('error', 'Google ID ini sudah dihubungkan ke akun lain');
        }

        // Update user dengan Google ID
        Auth::user()->update([
            'google_id' => $googleUser->getId(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
        ]);

        return back()->with('success', 'Google berhasil dihubungkan ke akun Anda');
    }
}
