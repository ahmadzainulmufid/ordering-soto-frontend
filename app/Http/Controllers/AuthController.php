<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        $response = Http::post(config('services.api.base_url') . '/auth/login', [
            'email'    => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
    $json  = $response->json();
    $data  = $json['data'] ?? $json;
    $token = $data['access_token'] ?? null;
    $user  = $data['user'] ?? null;

    session([
        'auth_token' => $token,
        'user'       => $user,
    ]);

    if ($request->has('remember') && $token) {
        cookie()->queue('remember_auth_token', $token, 60 * 24 * 30);
    }

    // Redirect otomatis berdasarkan Role
    $role = strtolower($user['role'] ?? '');

    switch ($role) {
        case 'owner':
            return redirect()->route('owner.dashboard')->with('success', 'Selamat datang kembali, Owner!');
        case 'cashier':
            return redirect()->route('cashier.orders')->with('success', 'Selamat bertugas, Kasir!');
        case 'kitchen':
            return redirect()->route('kitchen.orders')->with('success', 'Selamat bertugas, Dapur!');
        default:
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
    }
}

        return back()->withErrors([
            'email' => $response->json('message') ?? 'Email atau password salah.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $response = Http::post(config('services.api.base_url') . '/auth/register', [
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'role'      => $request->role,
            'password'  => $request->password,
        ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Registrasi akun berhasil! Silakan masuk.');
        }

        return back()->with('error', $response->json('message') ?? 'Registrasi gagal.')->withInput();
    }

    public function logout()
    {
        session()->forget(['auth_token', 'user']);
        session()->flush();
        cookie()->queue(cookie()->forget('remember_auth_token'));

        return redirect()->route('login')->with('success', 'Berhasil keluar sistem.');
    }
}