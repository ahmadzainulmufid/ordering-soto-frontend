@extends('layouts.owner')

@section('title', 'Dashboard - Soto Lamongan Cak Mufid')
@section('header_title', 'Dashboard Utama Owner')

@section('content')

    <!-- Flash Notifikasi Success saat Login -->
    @if (session('success'))
        <div id="alert-success"
            class="bg-secondary-container text-on-secondary-container p-4 rounded-2xl border border-secondary/30 flex items-center justify-between shadow-sm animate-fade-in mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary text-2xl"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div>
                    <h4 class="font-label-md font-bold">Login Berhasil!</h4>
                    <p class="text-xs text-on-secondary-container/80">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="p-1 hover:bg-secondary/10 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    <!-- Summary Cards Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Pesanan Hari Ini -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-primary-container/20 text-primary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                </div>
                <span class="text-secondary font-label-sm text-label-sm flex items-center">Hari Ini</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pesanan Selesai Hari Ini</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface font-bold">{{ $todayOrdersCount }}</h3>
            </div>
        </div>

        <!-- Card 2: Pendapatan Hari Ini -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-secondary-container/20 text-secondary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
                <span class="text-secondary font-label-sm text-label-sm flex items-center">Omset</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pendapatan Hari Ini</p>
                <h3 class="font-headline-lg text-2xl font-bold text-on-surface">
                    Rp {{ number_format($todayRevenue, 0, ',', '.') }}
                </h3>
            </div>
        </div>

        <!-- Card 3: Pesanan Sedang Berjalan -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-high text-primary rounded-xl">
                    <span class="material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">pending_actions</span>
                </div>
                <span class="text-on-surface-variant font-label-sm text-label-sm">Antrean Resto</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pesanan Aktif Diproses</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface font-bold">{{ $activeOrdersCount }}</h3>
            </div>
        </div>

        <!-- Card 4: Stok Habis / Perhatian -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-tertiary-container/20 text-tertiary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                </div>
                <span class="text-tertiary font-label-sm text-label-sm font-bold">Perhatian</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Menu Stok Habis</p>
                <h3 class="font-headline-lg text-headline-lg text-tertiary font-bold">{{ $outOfStockCount }}</h3>
            </div>
        </div>
    </section>

    <!-- Chart Section (Grafik Interaktif Omset Mingguan) -->
    <section class="tonal-layer-1 p-8 rounded-2xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="font-title-md text-title-md text-on-surface font-bold">Tren Penjualan Mingguan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Grafik omset harian resto dalam 7 hari terakhir
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('owner.reports.index') }}"
                    class="px-4 py-2 bg-primary text-white font-label-md text-label-md rounded-xl hover:bg-primary/90 transition-all shadow-md flex items-center gap-1 font-bold">
                    <span class="material-symbols-outlined text-sm">analytics</span> Detail Laporan
                </a>
            </div>
        </div>

        <div class="relative h-72 w-full bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/30">
            <canvas id="weeklyOwnerChart"></canvas>
        </div>
    </section>

    <!-- Monitoring Transaksi Terbaru (Read-Only) -->
    <section class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-title-md text-title-md text-on-surface font-bold">Monitor Transaksi Terbaru</h2>
                <p class="text-xs text-on-surface-variant">Pantau pesanan yang baru saja masuk secara *real-time*.</p>
            </div>
            <a class="text-primary font-label-md text-label-md flex items-center hover:underline font-bold"
                href="{{ route('owner.orders.index') }}">
                Lihat Semua Transaksi <span class="material-symbols-outlined text-[18px] ml-1">arrow_forward</span>
            </a>
        </div>

        <div class="bg-surface-bright rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-surface-container-high text-on-surface font-bold border-b border-outline-variant/30">
                        <tr>
                            <th class="p-4">Kode Order</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Tipe Pesanan</th>
                            <th class="p-4">Total Pembayaran</th>
                            <th class="p-4">Status Pesanan</th>
                            <th class="p-4 text-right">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($recentOrders as $ord)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 font-mono font-bold text-primary">{{ $ord['order_code'] }}</td>
                                <td class="p-4 font-bold">{{ $ord['customer_name'] }}</td>
                                <td class="p-4">
                                    <span
                                        class="uppercase font-bold text-[10px] px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                        {{ str_replace('_', ' ', $ord['order_type']) }}
                                    </span>
                                </td>
                                <td class="p-4 font-bold text-secondary">Rp
                                    {{ number_format($ord['total'] ?? 0, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @php
                                        $badgeClass = match (strtolower($ord['status'] ?? '')) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'cooking' => 'bg-orange-100 text-orange-800',
                                            'ready' => 'bg-purple-100 text-purple-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase {{ $badgeClass }}">
                                        {{ $ord['status'] ?? 'PENDING' }}
                                    </span>
                                </td>
                                <td class="p-4 text-right text-on-surface-variant font-mono text-[11px]">
                                    {{ date('H:i, d M Y', strtotime($ord['created_at'] ?? 'now')) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-on-surface-variant italic">Belum ada
                                    transaksi pesanan terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Script Chart.js & Auto Close Alert -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data Omset Mingguan dari Backend
        const weeklyData = @json($weeklySales);

        const ctx = document.getElementById('weeklyOwnerChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(weeklyData),
                datasets: [{
                    label: 'Omset Penjualan (Rp)',
                    data: Object.values(weeklyData),
                    backgroundColor: '#1e5e3a',
                    borderRadius: 8,
                    hoverBackgroundColor: '#785900'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Auto Close Alert Success Login
        setTimeout(() => {
            const alert = document.getElementById('alert-success');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 4000);
    </script>
@endsection
