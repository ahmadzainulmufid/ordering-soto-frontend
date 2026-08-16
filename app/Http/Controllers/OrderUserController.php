<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderUserController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string',
            'order_type'     => 'required|in:dine_in,takeaway,delivery',
            'payment_method' => 'required|in:cash,qris,online_payment',
            'items_json'     => 'required|string',
        ]);

        try {
            $items = json_decode($request->items_json, true);

            $payload = [
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone ?? '',
                'order_type'       => $request->order_type,
                'table_id'         => $request->table_id ? (int) $request->table_id : null,
                'delivery_address' => $request->delivery_address ?? '',
                'payment_method'   => $request->payment_method,
                'notes'            => $request->notes ?? '',
                'items'            => $items,
            ];

            // Kirim HTTP POST ke Backend Go
            $response = Http::acceptJson()->post("{$this->apiUrl}/orders", $payload);

            if ($response->successful()) {
                $orderData = $response->json('data');
                $orderCode = $orderData['order_code'] ?? '';
                $snapToken = $orderData['snap_token'] ?? null;

                return redirect()->route('orders.success', [
                    'code'           => $orderCode,
                    'payment_method' => $request->payment_method,
                    'snap_token'     => $snapToken
                ]);
            }

            // Ambil detail error dari API Go untuk ditampilkan di alert Laravel
            $errorMessage = $response->json('message') 
                ?? $response->json('error') 
                ?? ('API Error (HTTP ' . $response->status() . '): ' . $response->body());

            return redirect()->back()->with('error', $errorMessage);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function success(Request $request, $code)
    {
        $response = Http::get("{$this->apiUrl}/orders/code/{$code}");
        $order = $response->successful() ? $response->json('data') : null;
        
        $snapToken = $request->query('snap_token');
        
        if ($order && empty($order['payment_method'])) {
            $order['payment_method'] = $request->query('payment_method');
        }

        return view('pages.order_success', compact('order', 'code', 'snapToken'));
    }
}