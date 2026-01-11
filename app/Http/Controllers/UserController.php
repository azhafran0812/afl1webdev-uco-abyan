<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Wajib ditambahkan untuk mengambil user yang sedang login

class UserController extends Controller
{
    // --- FITUR REGISTER (Sesi Sebelumnya) ---

    // Tampilkan Form Register
    public function create()
    {
        return view('auth.register');
    }

    // Proses Simpan User Baru
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // butuh input name="password_confirmation" di form
        ]);

        // Simpan ke Database
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // --- FITUR BARU: EDIT PROFIL ---

    // Tampilkan Form Edit Profil
    public function edit()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Proses Update Profil
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            // Email harus unik, tapi kecualikan email milik user ini sendiri (. $user->id)
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // Password bersifat opsional (nullable), hanya divalidasi jika diisi
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update Nama & Email
        $user->name = $request->name;
        $user->email = $request->email;

        // Cek jika user mengisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
