@extends('layouts.admin')

@section('title', 'Admin Dashboard - Soto Lamongan Cak Mufid')
@section('header_title', 'Dashboard Operasional')

@section('content')

    <!-- Flash Message Success -->
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

    <!-- Operasional Summary Cards -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pesanan Hari Ini -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default border border-outline-variant/20">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-primary-container/20 text-primary rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                </div>
                <span
                    class="text-secondary font-label-sm text-xs font-bold bg-green-100 text-green-800 px-2.5 py-1 rounded-full">Aktif
                    Hari Ini</span>
            </div>
            <div>
                <p class="font-label-md text-sm text-on-surface-variant">Total Pesanan</p>
                <h3 class="font-headline-lg text-3xl font-bold text-on-surface">128 <span
                        class="text-sm font-normal text-on-surface-variant">Transaksi</span></h3>
            </div>
        </div>

        <!-- Pesanan Diproses / Dimasak -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default border border-outline-variant/20">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-blue-100 text-blue-700 rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">soup_kitchen</span>
                </div>
                <span
                    class="text-blue-800 font-label-sm text-xs font-bold bg-blue-100 px-2.5 py-1 rounded-full">Dapur</span>
            </div>
            <div>
                <p class="font-label-md text-sm text-on-surface-variant">Sedang Dimasak</p>
                <h3 class="font-headline-lg text-3xl font-bold text-on-surface">14 <span
                        class="text-sm font-normal text-on-surface-variant">Pesanan</span></h3>
            </div>
        </div>

        <!-- Total Item Menu -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default border border-outline-variant/20">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-purple-100 text-purple-700 rounded-xl">
                    <span class="material-symbols-outlined"
                        style="font-variation-settings: 'FILL' 1;">restaurant_menu</span>
                </div>
                <span
                    class="text-purple-800 font-label-sm text-xs font-bold bg-purple-100 px-2.5 py-1 rounded-full">Katalog</span>
            </div>
            <div>
                <p class="font-label-md text-sm text-on-surface-variant">Total Variasi Menu</p>
                <h3 class="font-headline-lg text-3xl font-bold text-on-surface">32 <span
                        class="text-sm font-normal text-on-surface-variant">Menu</span></h3>
            </div>
        </div>

        <!-- Stok Habis Warning -->
        <div
            class="tonal-layer-1 p-6 rounded-2xl flex flex-col justify-between hover:-translate-y-1 transition-all cursor-default border border-outline-variant/20">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-red-100 text-error rounded-xl">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                </div>
                <span
                    class="text-error font-label-sm text-xs font-bold bg-red-100 px-2.5 py-1 rounded-full">Perhatian</span>
            </div>
            <div>
                <p class="font-label-md text-sm text-on-surface-variant">Menu Stok Habis</p>
                <h3 class="font-headline-lg text-3xl font-bold text-error">3 <span
                        class="text-sm font-normal text-on-surface-variant">Menu Nonaktif</span></h3>
            </div>
        </div>
    </section>

    <!--Section Quick Action & Peringatan Stok -->
    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Peringatan Stok Habis / Menipis (2 Kolom) -->
        <div class="lg:col-span-2 tonal-layer-1 p-6 rounded-2xl border border-outline-variant/20 space-y-4">
            <div class="flex justify-between items-center pb-2 border-b border-outline-variant/30">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-error">warning</span>
                    <h3 class="font-title-md text-lg font-bold text-on-surface">Status Ketersediaan Menu</h3>
                </div>
                <a href="#" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                    Kelola Semua Menu <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>

            <div class="space-y-3">
                <!-- Item Stok Habis 1 -->
                <div class="flex items-center justify-between p-3.5 bg-red-50/50 rounded-xl border border-red-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center font-bold text-error">
                            <span class="material-symbols-outlined">block</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-on-surface">Soto Lamongan Daging Sapi</h4>
                            <p class="text-xs text-on-surface-variant">Kategori: Makanan Utama</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-error text-xs font-bold rounded-full">Habis (Kosong)</span>
                </div>

                <!-- Item Stok Habis 2 -->
                <div class="flex items-center justify-between p-3.5 bg-red-50/50 rounded-xl border border-red-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center font-bold text-error">
                            <span class="material-symbols-outlined">block</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-on-surface">Es Jeruk Peras Murni</h4>
                            <p class="text-xs text-on-surface-variant">Kategori: Minuman</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-red-100 text-error text-xs font-bold rounded-full">Habis (Kosong)</span>
                </div>

                <!-- Item Stok Menipis 3 -->
                <div class="flex items-center justify-between p-3.5 bg-amber-50/50 rounded-xl border border-amber-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg bg-surface-container flex items-center justify-center font-bold text-amber-700">
                            <span class="material-symbols-outlined">running_with_errors</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-on-surface">Sate Kulit Ayam (Porsi)</h4>
                            <p class="text-xs text-on-surface-variant">Kategori: Pendamping / Ekstra</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded-full">Tersisa 4
                        Porsi</span>
                </div>
            </div>
        </div>

        <!-- Quick Menu Actions (1 Kolom) -->
        <div class="tonal-layer-1 p-6 rounded-2xl border border-outline-variant/20 flex flex-col justify-between space-y-4">
            <div>
                <h3 class="font-title-md text-lg font-bold text-on-surface mb-1">Aksi Cepat Admin</h3>
                <p class="text-xs text-on-surface-variant">Pintasan tugas operasional harian.</p>
            </div>

            <div class="space-y-3">
                <a href="#"
                    class="w-full py-3 px-4 bg-primary text-on-primary font-bold text-sm rounded-xl flex items-center justify-between hover:bg-primary/90 transition-all shadow-sm">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">add_circle</span>
                        Tambah Menu Baru
                    </span>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>

                <a href="#"
                    class="w-full py-3 px-4 bg-surface-container hover:bg-surface-container-high font-bold text-sm text-on-surface rounded-xl flex items-center justify-between transition-all border border-outline-variant/30">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">edit_note</span>
                        Update Harga & Stok
                    </span>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>

                <a href="#"
                    class="w-full py-3 px-4 bg-surface-container hover:bg-surface-container-high font-bold text-sm text-on-surface rounded-xl flex items-center justify-between transition-all border border-outline-variant/30">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">category</span>
                        Kelola Kategori
                    </span>
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </a>
            </div>

            <div class="p-3.5 bg-primary-container/20 rounded-xl border border-primary-container/30">
                <p class="text-xs text-on-surface-variant flex items-center gap-1.5 font-medium">
                    <span class="material-symbols-outlined text-sm text-primary">info</span>
                    Perubahan harga & stok langsung sinkron ke sistem Kasir.
                </p>
            </div>
        </div>

    </section>

    <!-- Monitoring Antrean Pesanan Terbaru (Live Watch) -->
    <section class="space-y-4">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-title-md text-xl text-on-surface font-bold">Monitoring Pesanan Berjalan</h2>
                <p class="text-xs text-on-surface-variant">Supervisi status pesanan di Kasir dan Dapur</p>
            </div>
            <a class="text-primary font-bold text-sm flex items-center hover:underline" href="#">
                Pantau Semua Antrean <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Order 1: Dimasak Dapur -->
            <div class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30">
                <div class="p-4 bg-amber-50 flex justify-between items-center border-b border-amber-100">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">#ORD-3012</h4>
                        <p class="text-xs text-on-surface-variant">Meja 02 • 14:10 WIB</p>
                    </div>
                    <span class="px-3 py-1 bg-amber-100 text-amber-900 rounded-full text-[11px] font-bold uppercase">Proses
                        Dapur</span>
                </div>
                <div class="p-4 space-y-3">
                    <ul class="text-xs space-y-2 text-on-surface">
                        <li class="flex justify-between"><span>2x Soto Ayam Campur</span> <strong class="font-bold">2
                                Porsi</strong></li>
                        <li class="flex justify-between"><span>2x Teh Manis Hangat</span> <strong class="font-bold">2
                                Gelas</strong></li>
                    </ul>
                </div>
            </div>

            <!-- Order 2: Siap Saji -->
            <div class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30">
                <div class="p-4 bg-green-50 flex justify-between items-center border-b border-green-100">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">#ORD-3011</h4>
                        <p class="text-xs text-on-surface-variant">Meja 08 • 14:05 WIB</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-900 rounded-full text-[11px] font-bold uppercase">Siap
                        Disajikan</span>
                </div>
                <div class="p-4 space-y-3">
                    <ul class="text-xs space-y-2 text-on-surface">
                        <li class="flex justify-between"><span>1x Soto Ayam Pisah</span> <strong class="font-bold">1
                                Porsi</strong></li>
                        <li class="flex justify-between"><span>1x Es Jeruk</span> <strong class="font-bold">1
                                Gelas</strong></li>
                    </ul>
                </div>
            </div>

            <!-- Order 3: Pesanan Baru -->
            <div class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30">
                <div class="p-4 bg-blue-50 flex justify-between items-center border-b border-blue-100">
                    <div>
                        <h4 class="font-bold text-sm text-on-surface">#ORD-3013</h4>
                        <p class="text-xs text-on-surface-variant">Takeaway • Baru saja</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-[11px] font-bold uppercase">Pesanan
                        Baru</span>
                </div>
                <div class="p-4 space-y-3">
                    <ul class="text-xs space-y-2 text-on-surface">
                        <li class="flex justify-between"><span>3x Soto Spesial Ceker</span> <strong class="font-bold">3
                                Porsi</strong></li>
                        <li class="flex justify-between"><span>3x Krupuk Udang</span> <strong class="font-bold">3
                                Bks</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Auto-close Alert Notification Script -->
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
