<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReportController extends Controller
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

    public function index(Request $request)
    {
        try {
            $token = $this->getToken();
            $response = Http::withToken($token)->get("{$this->apiUrl}/admin/orders");
            $orders = $response->successful() ? ($response->json('data') ?? []) : [];

            // Hitung Omset & Total Pesanan Selesai
            $totalRevenue = 0;
            $completedOrdersCount = 0;
            $dailySales = [];
            $monthlySales = [];
            $productSales = [];

            foreach ($orders as $order) {
                // Hanya hitung pesanan yang berstatus 'completed' atau 'ready' / 'served'
                if (in_array(strtolower($order['status'] ?? ''), ['completed', 'served', 'ready', 'confirmed'])) {
                    $totalRevenue += ($order['total'] ?? 0);
                    $completedOrdersCount++;

                    // Olah Data Grafik Harian (Berdasarkan Tanggal)
                    $date = date('d M', strtotime($order['created_at'] ?? 'now'));
                    $dailySales[$date] = ($dailySales[$date] ?? 0) + ($order['total'] ?? 0);

                    // Olah Data Grafik Bulanan
                    $month = date('M Y', strtotime($order['created_at'] ?? 'now'));
                    $monthlySales[$month] = ($monthlySales[$month] ?? 0) + ($order['total'] ?? 0);

                    // Rekap Produk Terlaris
                    foreach ($order['items'] ?? [] as $item) {
                        $pName = $item['product_name'] ?? 'Menu';
                        $qty = $item['quantity'] ?? 0;
                        $productSales[$pName] = ($productSales[$pName] ?? 0) + $qty;
                    }
                }
            }

            // Urutkan Produk Terlaris (Top 5)
            arsort($productSales);
            $topProducts = array_slice($productSales, 0, 5, true);

            return view('pages.owner.reports', compact(
                'totalRevenue',
                'completedOrdersCount',
                'dailySales',
                'monthlySales',
                'topProducts'
            ));

        } catch (\Exception $e) {
            return view('pages.owner.reports', [
                'totalRevenue' => 0,
                'completedOrdersCount' => 0,
                'dailySales' => [],
                'monthlySales' => [],
                'topProducts' => []
            ])->with('error', 'Gagal memuat laporan: ' . $e->getMessage());
        }
    }
}