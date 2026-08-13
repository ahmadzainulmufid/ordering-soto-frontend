<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
        $json = $response->json();
        
        // Ambil token & user dari 'data' wrapper bawaan Go
        $data  = $json['data'] ?? $json;
        $token = $data['access_token'] ?? null;

        session([
            'auth_token' => $token,
            'user'       => $data['user'] ?? null, 
        ]);

        if ($request->has('remember') && $token) {
            cookie()->queue('remember_auth_token', $token, 60 * 24 * 30);
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

// Route Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
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
})->name('register.post');

// Route Setting
Route::get('/admin/setting', function (Request $request) {
    $token = session('auth_token');

    if (!$token) {
        return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir, silakan login ulang.');
    }

    $users = [];

    if ($request->get('tab', 'staff') === 'staff') {
        $response = Http::withToken($token)
            ->get(config('services.api.base_url') . '/admin/users');

        if ($response->successful()) {
            $json = $response->json();
            $users = $json['data'] ?? $json ?? [];
        }
    }

    $profile = [
        'restaurant_name' => 'Soto Lamongan Cak Mufid',
        'address'         => 'Jl. Raya Lamongan No. 45, Jawa Timur',
        'phone'           => '081234567890',
        'opening_hours'   => '08.00 - 21.00 WIB',
    ];

    if (Storage::exists('restaurant.json')) {
        $profile = json_decode(Storage::get('restaurant.json'), true) ?? $profile;
    }

    return view('pages.admin.setting', compact('users', 'profile'));
})->name('admin.setting');


Route::post('/admin/setting/profile', function (Request $request) {
    $request->validate([
        'restaurant_name' => 'required|string|max:255',
        'address'         => 'required|string',
        'phone'           => 'required|string',
        'opening_hours'   => 'required|string',
    ]);

    $data = [
        'restaurant_name' => $request->restaurant_name,
        'address'         => $request->address,
        'phone'           => $request->phone,
        'opening_hours'   => $request->opening_hours,
    ];

    // Simpan data ke storage/app/restaurant.json
    Storage::put('restaurant.json', json_encode($data, JSON_PRETTY_PRINT));

    return back()->with('success', 'Profil restoran berhasil diperbarui!');
})->name('admin.setting.profile.update');

// Route Simpan User Staf dari Modal Setting
Route::post('/admin/users', function (Request $request) {
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email'     => 'required|email',
        'phone'     => 'nullable|string|max:20',
        'role'      => 'required|in:admin,cashier,kitchen', 
        'password'  => 'required|min:8',
    ]);

    $token = session('auth_token');

    if (!$token) {
        return back()->with('error', 'Sesi Anda telah berakhir, silakan login ulang.');
    }

    $response = Http::withToken($token)
        ->post(config('services.api.base_url') . '/admin/users', [
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone ?? '',
            'role'      => $request->role,
            'password'  => $request->password,
        ]);

    if ($response->successful()) {
        return back()->with('success', 'Staf baru berhasil ditambahkan!');
    }

    $errorMessage = $response->json('message') ?? 'Gagal menambahkan akun staf.';
    
    return back()->with('error', $errorMessage)->withInput();
})->name('admin.users.store');

Route::put('/admin/users/{id}', function (Request $request, $id) {
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone'     => 'nullable|string|max:20',
        'role'      => 'required|in:admin,cashier,kitchen',
    ]);

    $token = session('auth_token');

    // Tembak API Go untuk Update User
    $response = Http::withToken($token)
        ->put(config('services.api.base_url') . '/admin/users/' . $id, [
            'full_name' => $request->full_name,
            'phone'     => $request->phone ?? '',
            'role'      => $request->role,
        ]);

    if ($response->successful()) {
        return back()->with('success', 'Data staf berhasil diperbarui!');
    }

    return back()->with('error', $response->json('message') ?? 'Gagal memperbarui staf.');
})->name('admin.users.update');

Route::delete('/admin/users/{id}', function ($id) {
    $token = session('auth_token');

    // Tembak API Go untuk Delete User
    $response = Http::withToken($token)
        ->delete(config('services.api.base_url') . '/admin/users/' . $id);

    if ($response->successful()) {
        return back()->with('success', 'Akun staf berhasil dihapus!');
    }

    return back()->with('error', $response->json('message') ?? 'Gagal menghapus staf.');
})->name('admin.users.destroy');