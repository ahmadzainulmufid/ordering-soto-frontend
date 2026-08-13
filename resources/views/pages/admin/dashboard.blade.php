@extends('layouts.admin')

@section('title', 'Admin Dashboard - Soto Lamongan Cak Mufid')
@section('header_title', 'Dashboard Utama')

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
        <!-- Card 1 -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:translate-y-[-4px] transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-primary-container/20 text-primary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                </div>
                <span class="text-secondary font-label-sm text-label-sm flex items-center">+12% <span
                        class="material-symbols-outlined text-[14px]">arrow_upward</span></span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pesanan Hari Ini</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface">128</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:translate-y-[-4px] transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-secondary-container/20 text-secondary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">payments</span>
                </div>
                <span class="text-secondary font-label-sm text-label-sm flex items-center">+8% <span
                        class="material-symbols-outlined text-[14px]">arrow_upward</span></span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pendapatan Hari Ini</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface">Rp 4.2M</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:translate-y-[-4px] transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-surface-container-high text-primary rounded-xl">
                    <span class="material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">pending_actions</span>
                </div>
                <span class="text-on-surface-variant font-label-sm text-label-sm">Stabil</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Pesanan Aktif</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface">14</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:translate-y-[-4px] transition-all cursor-default">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-tertiary-container/20 text-tertiary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                </div>
                <span class="text-tertiary font-label-sm text-label-sm">Perhatian</span>
            </div>
            <div>
                <p class="font-label-md text-label-md text-on-surface-variant">Stok Habis</p>
                <h3 class="font-headline-lg text-headline-lg text-on-surface">3</h3>
            </div>
        </div>
    </section>

    <!-- Chart Section -->
    <section class="tonal-layer-1 p-8 rounded-2xl">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="font-title-md text-title-md text-on-surface font-bold">Tren Penjualan Mingguan</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Data transaksi 7 hari terakhir</p>
            </div>
            <div class="flex gap-2">
                <button
                    class="px-4 py-2 bg-surface-container-low text-on-surface-variant font-label-md text-label-md rounded-lg border border-outline-variant hover:bg-surface-variant transition-colors">Unduh
                    Laporan</button>
                <select
                    class="bg-surface-container-low text-on-surface font-label-md text-label-md rounded-lg border border-outline-variant px-4 py-2 focus:ring-primary focus:border-primary">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
        </div>

        <div
            class="relative h-64 w-full bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant flex flex-col justify-end">
            <div class="absolute inset-x-0 bottom-0 chart-gradient h-full"></div>
            <!-- Mock Chart Bars -->
            <div class="flex items-end justify-between px-10 h-full relative z-10 pt-10">
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[40%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Sen</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[60%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Sel</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[55%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Rab</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[80%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Kam</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[70%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Jum</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/40 w-12 h-[95%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-primary font-bold">Sab</span>
                </div>
                <div class="flex flex-col items-center gap-2 group w-full">
                    <div class="bg-primary/20 w-12 h-[85%] rounded-t-lg group-hover:bg-primary transition-all"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Min</span>
                </div>
            </div>
            <!-- Chart Overlay Lines -->
            <div class="absolute inset-0 flex flex-col justify-between p-4 pointer-events-none opacity-20">
                <div class="border-t border-dashed border-outline w-full"></div>
                <div class="border-t border-dashed border-outline w-full"></div>
                <div class="border-t border-dashed border-outline w-full"></div>
                <div class="border-t border-dashed border-outline w-full"></div>
            </div>
        </div>
    </section>

    <!-- Incoming Orders Section -->
    <section class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="font-title-md text-title-md text-on-surface font-bold">Antrean Pesanan Masuk</h2>
            <a class="text-primary font-label-md text-label-md flex items-center hover:underline" href="#">
                Lihat Semua Antrean <span class="material-symbols-outlined text-[18px] ml-1">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Order Card 1 -->
            <div
                class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant hover:shadow-md transition-shadow">
                <div class="p-5 bg-surface-container-low flex justify-between items-center">
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold">#ORD-2901</h4>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Meja 04 • 12:45</p>
                    </div>
                    <span
                        class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-[10px] font-bold uppercase tracking-wider">Baru</span>
                </div>
                <div class="p-5 space-y-4">
                    <ul class="space-y-2">
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>2x Soto Lamongan Campur</span>
                            <span class="font-bold">Rp 50.000</span>
                        </li>
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>1x Kerupuk Udang (Isi 3)</span>
                            <span class="font-bold">Rp 15.000</span>
                        </li>
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>2x Es Jeruk Peras</span>
                            <span class="font-bold">Rp 24.000</span>
                        </li>
                    </ul>
                    <div class="pt-4 border-t border-outline-variant flex gap-3">
                        <button
                            class="flex-1 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity active:scale-95 duration-100">Terima</button>
                        <button
                            class="flex-1 py-2 border border-tertiary text-tertiary rounded-lg font-label-md text-label-md hover:bg-error-container transition-colors active:scale-95 duration-100">Tolak</button>
                    </div>
                </div>
            </div>

            <!-- Order Card 2 -->
            <div
                class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant hover:shadow-md transition-shadow">
                <div class="p-5 bg-surface-container-low flex justify-between items-center">
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold">#ORD-2902</h4>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Takeaway • 12:48</p>
                    </div>
                    <span
                        class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-[10px] font-bold uppercase tracking-wider">Baru</span>
                </div>
                <div class="p-5 space-y-4">
                    <ul class="space-y-2">
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>3x Soto Lamongan Spesial</span>
                            <span class="font-bold">Rp 105.000</span>
                        </li>
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>3x Telur Asin</span>
                            <span class="font-bold">Rp 21.000</span>
                        </li>
                    </ul>
                    <div
                        class="p-3 bg-surface-container rounded-lg italic font-label-sm text-label-sm text-on-surface-variant">
                        "Koya-nya banyakin ya pak, terima kasih."
                    </div>
                    <div class="pt-4 border-t border-outline-variant flex gap-3">
                        <button
                            class="flex-1 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:opacity-90 transition-opacity active:scale-95 duration-100">Terima</button>
                        <button
                            class="flex-1 py-2 border border-tertiary text-tertiary rounded-lg font-label-md text-label-md hover:bg-error-container transition-colors active:scale-95 duration-100">Tolak</button>
                    </div>
                </div>
            </div>

            <!-- Order Card 3 -->
            <div
                class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant hover:shadow-md transition-shadow opacity-90 grayscale-[0.2]">
                <div class="p-5 bg-surface-container-low flex justify-between items-center">
                    <div>
                        <h4 class="font-label-md text-label-md text-on-surface font-bold">#ORD-2895</h4>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Meja 12 • 12:30</p>
                    </div>
                    <span
                        class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-[10px] font-bold uppercase tracking-wider">Dimasak</span>
                </div>
                <div class="p-5 space-y-4">
                    <ul class="space-y-2">
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>1x Soto Lamongan Pisah</span>
                            <span class="font-bold">Rp 28.000</span>
                        </li>
                        <li class="flex justify-between items-center font-body-md text-body-md text-on-surface">
                            <span>1x Es Teh Manis</span>
                            <span class="font-bold">Rp 6.000</span>
                        </li>
                    </ul>
                    <div class="pt-4 border-t border-outline-variant">
                        <button
                            class="w-full py-2 bg-primary-fixed-dim text-on-primary-fixed rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 cursor-wait">
                            <span class="material-symbols-outlined text-[18px] animate-spin">refresh</span>
                            Sedang Disiapkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Auto Close Notification Script -->
    <script>
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
