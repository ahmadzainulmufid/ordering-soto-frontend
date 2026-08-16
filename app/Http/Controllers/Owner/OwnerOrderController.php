<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OwnerOrderController extends Controller
{
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.api.base_url', 'http://localhost:8080/api');
    }

    private function getToken()
    {
        $token = session('auth_token') ?? request()->cookie('remember_auth_token');
        return Str::replaceFirst('Bearer ', '', $token ?? '');
    }

    public function index()
    {
        try {
            $token = $this->getToken();
            $response = Http::withToken($token)->get("{$this->apiUrl}/admin/orders");
            $orders = $response->successful() ? ($response->json('data') ?? []) : [];

            return view('pages.owner.orders', compact('orders'));
        } catch (\Exception $e) {
            return view('pages.owner.orders', ['orders' => []])->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);

        try {
            $token = $this->getToken();
            $response = Http::withToken($token)
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