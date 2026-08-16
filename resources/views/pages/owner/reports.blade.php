@extends('layouts.owner')

@section('title', 'Laporan Penjualan - Owner Dashboard')
@section('header_title', 'Laporan Penjualan & Analytics')

@section('content')
    <div class="space-y-8">

        <!-- Header Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Total Omset -->
            <div
                class="bg-surface-bright rounded-2xl p-6 border border-outline-variant/30 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-primary-container text-on-primary-container rounded-xl flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">payments</span>
                </div>
                <div>
                    <span class="text-xs text-on-surface-variant font-medium block">Total Pendapatan</span>
                    <h3 class="font-headline-sm text-2xl font-bold text-primary">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- Card 2: Pesanan Selesai -->
            <div
                class="bg-surface-bright rounded-2xl p-6 border border-outline-variant/30 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-secondary-container text-on-secondary-container rounded-xl flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                </div>
                <div>
                    <span class="text-xs text-on-surface-variant font-medium block">Pesanan Selesai</span>
                    <h3 class="font-headline-sm text-2xl font-bold text-secondary">
                        {{ $completedOrdersCount }} Transaksi
                    </h3>
                </div>
            </div>

            <!-- Card 3: Rata-rata Transaksi -->
            <div
                class="bg-surface-bright rounded-2xl p-6 border border-outline-variant/30 shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 bg-tertiary-container text-on-tertiary-container rounded-xl flex items-center justify-center font-bold">
                    <span class="material-symbols-outlined text-2xl">trending_up</span>
                </div>
                <div>
                    <span class="text-xs text-on-surface-variant font-medium block">Rata-rata Order</span>
                    <h3 class="font-headline-sm text-2xl font-bold text-tertiary">
                        Rp
                        {{ number_format($completedOrdersCount > 0 ? $totalRevenue / $completedOrdersCount : 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <!-- Charts Section (Grid 2 Kolom) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Grafik Penjualan Harian -->
            <div class="bg-surface-bright p-6 rounded-2xl border border-outline-variant/30 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-title-md text-base font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">show_chart</span>
                        Grafik Penjualan Harian
                    </h3>
                </div>
                <div class="h-64">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>

            <!-- Grafik Penjualan Bulanan -->
            <div class="bg-surface-bright p-6 rounded-2xl border border-outline-variant/30 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-title-md text-base font-bold text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">bar_chart</span>
                        Grafik Omset Bulanan
                    </h3>
                </div>
                <div class="h-64">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Selling Menu Table -->
        <div class="bg-surface-bright rounded-2xl p-6 border border-outline-variant/30 shadow-sm">
            <h3 class="font-title-md text-base font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-amber-600">military_tech</span>
                Menu Terlaris (Top 5)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-surface-container-high text-on-surface font-bold border-b border-outline-variant/30">
                        <tr>
                            <th class="p-3">Peringkat</th>
                            <th class="p-3">Nama Menu</th>
                            <th class="p-3 text-right">Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @php $rank = 1; @endphp
                        @forelse ($topProducts as $name => $qty)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-3 font-bold text-primary">#{{ $rank++ }}</td>
                                <td class="p-3 font-bold text-on-surface">{{ $name }}</td>
                                <td class="p-3 text-right font-bold text-secondary">{{ $qty }} Porsi</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-6 text-center text-on-surface-variant italic">Belum ada data
                                    penjualan menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- CDN Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari Controller
        const dailyData = @json($dailySales);
        const monthlyData = @json($monthlySales);

        // Render Grafik Harian (Line Chart)
        const ctxDaily = document.getElementById('dailyChart').getContext('2d');
        new Chart(ctxDaily, {
            type: 'line',
            data: {
                labels: Object.keys(dailyData),
                datasets: [{
                    label: 'Omset (Rp)',
                    data: Object.values(dailyData),
                    borderColor: '#1e5e3a',
                    backgroundColor: 'rgba(30, 94, 58, 0.1)',
                    fill: true,
                    tension: 0.3,
                    borderWidth: 3,
                    pointRadius: 4
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
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });

        // Render Grafik Bulanan (Bar Chart)
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        new Chart(ctxMonthly, {
            type: 'bar',
            data: {
                labels: Object.keys(monthlyData),
                datasets: [{
                    label: 'Omset (Rp)',
                    data: Object.values(monthlyData),
                    backgroundColor: '#785900',
                    borderRadius: 8
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
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
