<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', fn() => view('home'))->name('home');

Route::get('/menu', function () {
    return view('pages.menu');
})->name('menu');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:8',
    ]);

    $response = Http::post(config('services.api.base_url') . '/auth/login', [
        'email'    => $request->email,
        'password' => $request->password,
    ]);

    if ($response->successful()) {
        $data = $response->json();

        session([
            'auth_token' => $data['access_token'] ?? null,
            'user'       => $data['user'] ?? null, 
        ]);

        if ($request->has('remember')) {
            cookie()->queue('remember_auth_token', $data['access_token'] ?? '', 60 * 24 * 30);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali!');
    }

    return back()->withErrors([
        'email' => $response->json('message') ?? 'Email atau password salah.',
    ])->withInput($request->only('email', 'remember'));
});

Route::get('/admin/dashboard', function () {
    return view('pages.admin.dashboard');
})->name('admin.dashboard');

Route::get('/logout', function () {
    session()->forget(['auth_token', 'user']);
    session()->flush();
    cookie()->queue(cookie()->forget('remember_auth_token'));

    return redirect()->route('login')->with('success', 'Berhasil keluar sistem.');
})->name('logout');