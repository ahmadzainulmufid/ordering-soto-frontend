<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CashierOrderController extends Controller
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

            // Fetch pesanan & produk
            $orderRes = Http::withToken($token)->get("{$this->apiUrl}/admin/orders");
            $productRes = Http::withToken($token)->get("{$this->apiUrl}/products");
            $tableRes   = Http::withToken($token)->get("{$this->apiUrl}/tables");

            $orders = $orderRes->successful() ? ($orderRes->json('data') ?? []) : [];
            $products = $productRes->successful() ? ($productRes->json('data') ?? []) : [];
            $tables   = $tableRes->successful() ? ($tableRes->json('data') ?? []) : [];

            return view('pages.cashier.orders', compact('orders', 'products', 'tables'));
        } catch (\Exception $e) {
            return view('pages.cashier.orders', ['orders' => [], 'products' => [], 'tables' => []])
                ->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    // Pemesanan Manual dari Kasir
    public function storeManualOrder(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'order_type'     => 'required|in:dine_in,takeaway,delivery',
            'payment_method' => 'required|string',
            'items'          => 'required|array|min:1',
            'items.*.id'     => 'required|integer',
            'items.*.qty'    => 'required|integer|min:1',
        ]);

        try {
            $token = $this->getToken();

            $itemsPayload = [];
            foreach ($request->items as $item) {
                $itemsPayload[] = [
                    'product_id' => (int) $item['id'],
                    'quantity'   => (int) $item['qty'],
                    'notes'      => $item['notes'] ?? '',
                ];
            }

            $payload = [
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone ?? '-',
                'order_type'       => $request->order_type,
                'table_id'         => $request->table_id ? (int) $request->table_id : null,
                'payment_method'   => $request->payment_method,
                'notes'            => 'Pemesanan Manual Kasir',
                'items'            => $itemsPayload,
            ];

            $response = Http::withToken($token)->post("{$this->apiUrl}/orders", $payload);

            if ($response->successful()) {
                return redirect()->route('cashier.orders.index')->with('success', 'Pesanan manual kasir berhasil dibuat!');
            }

            return redirect()->back()->with('error', $response->json('message') ?? 'Gagal membuat pesanan manual.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Disetujui / Konfirmasi Pembayaran Tunai (Bayar di Kasir)
    public function confirmPayment($id)
    {
        try {
            $token = $this->getToken();

            $response = Http::withToken($token)->patch("{$this->apiUrl}/admin/orders/{$id}/status", [
                'status'         => 'confirmed',
                'payment_status' => 'paid',
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Pembayaran tunai disetujui dan status diubah menjadi PAID!');
            }

            $errorMessage = $response->json('message') ?? 'Gagal mengonfirmasi pembayaran (HTTP ' . $response->status() . ')';
            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Update Status Pesanan
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

    public function menuStock()
    {
        try {
            $token = $this->getToken();
            $response = Http::withToken($token)->get("{$this->apiUrl}/products");
            $products = $response->successful() ? ($response->json('data') ?? []) : [];

            return view('pages.cashier.menu_stock', compact('products'));
        } catch (\Exception $e) {
            return view('pages.cashier.menu_stock', ['products' => []])
                ->with('error', 'Gagal memuat stok produk: ' . $e->getMessage());
        }
    }
}