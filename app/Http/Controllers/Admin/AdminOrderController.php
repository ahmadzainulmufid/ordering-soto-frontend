<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminOrderController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    private function getToken()
    {
        // Ambil token dari session atau cookie
        $token = session('auth_token') ?? request()->cookie('remember_auth_token') ?? '';
        
        // Bersihkan prefix 'Bearer ' jika ada
        return trim(Str::replaceFirst('Bearer ', '', $token));
    }

    public function index()
    {
        try {
            $token = $this->getToken();

            // Panggil API Backend
            $response = Http::withToken($token)
                ->acceptJson()
                ->get("{$this->apiUrl}/admin/orders");

            // --- JIKA GAGAL RESPONSE / UNAUTHORIZED / 500 ---
            if (!$response->successful()) {
                // Catat log error untuk melihat respon sebenarnya dari API Backend
                Log::error('API Orders Admin Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                // Opsional: tampilkan pesan error ke halaman blade jika gagal
                $errorMessage = $response->json('message') ?? 'Gagal mengambil data dari API (Status: ' . $response->status() . ')';
                return view('pages.admin.orders', ['orders' => []])->with('error', $errorMessage);
            }

            // --- PENANGANAN STRUKTUR JSON ---
            // Cek apakah data dibungkus dalam key 'data' atau berupa array langsung di root
            $responseData = $response->json();
            $orders = isset($responseData['data']) ? $responseData['data'] : $responseData;

            // Pastikan hasil akhirnya berupa array
            if (!is_array($orders)) {
                $orders = [];
            }

            return view('pages.admin.orders', compact('orders'));

        } catch (\Exception $e) {
            Log::error('Exception Order Index: ' . $e->getMessage());
            return view('pages.admin.orders', ['orders' => []])->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        try {
            $token = $this->getToken();
            $response = Http::withToken($token)
                ->acceptJson()
                ->patch("{$this->apiUrl}/admin/orders/{$id}/status", [
                    'status' => $request->status,
                ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
            }

            return redirect()->back()->with('error', $response->json('message') ?? 'Gagal memperbarui status.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}