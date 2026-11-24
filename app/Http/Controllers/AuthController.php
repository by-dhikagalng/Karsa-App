<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() // Form login
    {
        return view('auth.login');
    }

    public function login(Request $request) // Proses login
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // cek email & password (Laravel otomatis mencocokan dengan hash password yang ada di db)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()
                ->intended(route('admin.events.index'))
                ->with('success', 'Berhasil login sebagai ' . Auth::user()->name . '.');
        }

        // jika gagal login, kembalikan ke halaman login dengan pesan error
        return back()
            ->withErrors([
                'email' => 'Email atau password yang anda masukkan salah.',
            ])
            ->onlyInput('email');
    }       

    public function logout(Request $request) // Logout
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda telah berhasil logout.');   
    }
}
