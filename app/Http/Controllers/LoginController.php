<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan Halaman Login
    public function login()
    {
        return view('auth.login');
    }

    // Proses Login
    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba Login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke halaman yang diminta sebelumnya atau ke home
            return redirect()->intended(route('home'))->with('success', 'Berhasil Login!');
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
