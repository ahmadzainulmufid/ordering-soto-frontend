<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class KitchenOrderController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    private function getToken()
    {
        $token = session('auth_token') ?? request()->cookie('remember_auth_token');
        if ($token && Str::startsWith($token, 'Bearer ')) {
            $token = Str::replaceFirst('Bearer ', '', $token);
        }
        return $token;
    }

    public function index()
    {
        try {
            $token = $this->getToken();

            // Fetch pesanan, produk, & meja untuk UI antrean dapur
            $orderRes   = Http::withToken($token)->get("{$this->apiUrl}/admin/orders");
            $productRes = Http::withToken($token)->get("{$this->apiUrl}/products");
            $tableRes   = Http::withToken($token)->get("{$this->apiUrl}/tables");

            $orders   = $orderRes->successful() ? ($orderRes->json('data') ?? []) : [];
            $products = $productRes->successful() ? ($productRes->json('data') ?? []) : [];
            $tables   = $tableRes->successful() ? ($tableRes->json('data') ?? []) : [];

            return view('pages.kitchen.orders', compact('orders', 'products', 'tables'));
        } catch (\Exception $e) {
            return view('pages.kitchen.orders', ['orders' => [], 'products' => [], 'tables' => []])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    // Update Status Pesanan (Mulai Masak / Ready / Sajikan)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        try {
            $token = $this->getToken();

            $response = Http::withToken($token)->patch("{$this->apiUrl}/admin/orders/{$id}/status", [
                'status' => strtolower($request->status)
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
            }

            $errorMessage = $response->json('message') ?? $response->json('error') ?? 'Gagal memperbarui status (HTTP ' . $response->status() . ')';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}