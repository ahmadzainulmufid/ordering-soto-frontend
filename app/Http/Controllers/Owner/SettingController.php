<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $token = session('auth_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir, silakan login ulang.');
        }

        $users = [];

        if ($request->get('tab', 'staff') === 'staff') {
            $response = Http::withToken($token)
                ->get(config('services.api.base_url') . '/admin/users');

            if ($response->successful()) {
                $json  = $response->json();
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

        return view('pages.owner.setting', compact('users', 'profile'));
    }

    public function updateProfile(Request $request)
    {
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

        Storage::put('restaurant.json', json_encode($data, JSON_PRETTY_PRINT));

        return back()->with('success', 'Profil restoran berhasil diperbarui!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'required|in:admin,cashier,kitchen',
            'password'  => 'required|min:8',
        ]);

        $token = session('auth_token');

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

        return back()->with('error', $response->json('message') ?? 'Gagal menambahkan akun staf.')->withInput();
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'role'      => 'required|in:admin,cashier,kitchen',
        ]);

        $token = session('auth_token');

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
    }

    public function destroyUser($id)
    {
        $token = session('auth_token');

        $response = Http::withToken($token)
            ->delete(config('services.api.base_url') . '/admin/users/' . $id);

        if ($response->successful()) {
            return back()->with('success', 'Akun staf berhasil dihapus!');
        }

        return back()->with('error', $response->json('message') ?? 'Gagal menghapus staf.');
    }
}