<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('guest.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'password.required' => 'Password harus diisi',
            ]
        );

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
            if ($role == 'mahasiswa') {
                if (auth()->user()->mahasiswa->status == 'approved') {
                    $request->session()->regenerate();
                    return redirect()->route('home');
                } elseif (auth()->user()->mahasiswa->status == 'rejected') {
                    Auth::logout();
                    return back()->with('error', 'Akun anda ditolak oleh Tim Capstone');
                } else {
                    Auth::logout();
                    return back()->with('error', 'Akun anda belum diverifikasi oleh Tim Capstone');
                }
            } else if ($role == 'dosen_pembimbing' || $role == 'dosen_penguji' || $role == 'dosen') {
                if (auth()->user()->dosen->status == 'approved') {
                    $request->session()->regenerate();
                    return redirect()->route('home');
                } elseif (auth()->user()->dosen->status == 'rejected') {
                    Auth::logout();
                    return back()->with('error', 'Akun anda ditolak oleh Tim Capstone');
                } else {
                    Auth::logout();
                    return back()->with('error', 'Akun anda belum diverifikasi oleh Tim Capstone');
                }
            } else if ($role == 'tim') {
                $request->session()->regenerate();
                return redirect()->route('home');
            } else {
                Auth::logout();
                return back()->with('error', 'Akun anda tidak terdaftar sebagai mahasiswa atau dosen');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
