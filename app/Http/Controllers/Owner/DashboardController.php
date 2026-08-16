<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DashboardController extends Controller
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
            
            // 1. Fetch Orders & Products
            $orderRes = Http::withToken($token)->get("{$this->apiUrl}/admin/orders");
            $productRes = Http::withToken($token)->get("{$this->apiUrl}/products");

            $orders = $orderRes->successful() ? ($orderRes->json('data') ?? []) : [];
            $products = $productRes->successful() ? ($productRes->json('data') ?? []) : [];

            // 2. Olah Statistik Utama Owner
            $todayRevenue = 0;
            $todayOrdersCount = 0;
            $activeOrdersCount = 0;
            $outOfStockCount = 0;

            $weeklySales = [
                'Sen' => 0, 'Sel' => 0, 'Rab' => 0, 'Kam' => 0, 'Jum' => 0, 'Sab' => 0, 'Min' => 0
            ];
            
            $todayDate = date('Y-m-d');

            // Hitung Stok Habis
            foreach ($products as $p) {
                if (($p['stock'] ?? 0) <= 0 || !($p['is_available'] ?? true)) {
                    $outOfStockCount++;
                }
            }

            // Hitung Statistik Transaksi
            foreach ($orders as $order) {
                $status = strtolower($order['status'] ?? '');
                $orderDate = date('Y-m-d', strtotime($order['created_at'] ?? 'now'));
                
                // Pesanan Aktif (Sedang Diproses/Memasak/Siap)
                if (in_array($status, ['pending', 'confirmed', 'cooking', 'ready', 'delivering'])) {
                    $activeOrdersCount++;
                }

                // Pesanan Selesai / Valid
                if (in_array($status, ['completed', 'served', 'ready', 'confirmed'])) {
                    // Cek Transaksi Hari Ini
                    if ($orderDate === $todayDate) {
                        $todayRevenue += ($order['total'] ?? 0);
                        $todayOrdersCount++;
                    }

                    // Mapping Penjualan Mingguan
                    $dayName = date('D', strtotime($order['created_at'] ?? 'now'));
                    $dayMap = [
                        'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 
                        'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab', 'Sun' => 'Min'
                    ];
                    if (isset($dayMap[$dayName])) {
                        $weeklySales[$dayMap[$dayName]] += ($order['total'] ?? 0);
                    }
                }
            }

            // Ambil 5 Pesanan Terbaru untuk Ringkasan Monitoring
            $recentOrders = array_slice($orders, 0, 5);

            return view('pages.owner.dashboard', compact(
                'todayRevenue',
                'todayOrdersCount',
                'activeOrdersCount',
                'outOfStockCount',
                'weeklySales',
                'recentOrders'
            ));

        } catch (\Exception $e) {
            return view('pages.owner.dashboard', [
                'todayRevenue' => 0,
                'todayOrdersCount' => 0,
                'activeOrdersCount' => 0,
                'outOfStockCount' => 0,
                'weeklySales' => ['Sen' => 0, 'Sel' => 0, 'Rab' => 0, 'Kam' => 0, 'Jum' => 0, 'Sab' => 0, 'Min' => 0],
                'recentOrders' => []
            ])->with('error', 'Gagal memuat data dashboard: ' . $e->getMessage());
        }
        // return view('pages.owner.dashboard');
    }
}