<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // proses login
    public function login(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // cek login
        if (Auth::attempt($credentials)) {

            // ✅ FIX TYPO (PENTING BANGET)
            $request->session()->regenerate();

            $user = Auth::user();

            // redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin');

                case 'dosen':
                    return redirect('/dosen');

                case 'mahasiswa':
                    return redirect('/mahasiswa');

                default:
                    Auth::logout();
                    return redirect('/login')->withErrors([
                        'email' => 'Role tidak dikenali',
                    ]);
            }
        }

        // kalau login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
