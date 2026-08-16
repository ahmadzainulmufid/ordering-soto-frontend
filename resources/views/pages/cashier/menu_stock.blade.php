@extends('layouts.cashier')

@section('title', 'Ketersediaan Menu & Stok - Soto Lamongan')
@section('header_title', 'Ketersediaan Stok Menu')

@section('content')
    <div class="space-y-6">

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-on-surface">Status Ketersediaan Menu & Stok</h2>
                <p class="text-xs text-on-surface-variant">Pantau sisa stok dan ketersediaan porsi menu soto secara
                    real-time.</p>
            </div>
            <div class="flex items-center gap-2 bg-surface-container px-4 py-2 rounded-xl text-xs font-bold text-on-surface">
                <span class="material-symbols-outlined text-primary text-sm">inventory_2</span>
                Total Menu: {{ count($products) }} Items
            </div>
        </div>

        <!-- Ringkasan Status Stok Cards -->
        @php
            $availableCount = 0;
            $outOfStockCount = 0;
            foreach ($products as $p) {
                if (($p['stock'] ?? 0) > 0 && ($p['is_available'] ?? true)) {
                    $availableCount++;
                } else {
                    $outOfStockCount++;
                }
            }
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Ready Stock -->
            <div
                class="bg-surface-bright p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">check_circle</span>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant font-medium block">Menu Tersedia</span>
                        <h3 class="text-xl font-bold text-green-700">{{ $availableCount }} Item</h3>
                    </div>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-green-100 text-green-800">Siap Saji</span>
            </div>

            <!-- Stok Habis -->
            <div
                class="bg-surface-bright p-5 rounded-2xl border border-outline-variant/30 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-xl">block</span>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant font-medium block">Stok Habis / Nonaktif</span>
                        <h3 class="text-xl font-bold text-red-700">{{ $outOfStockCount }} Item</h3>
                    </div>
                </div>
                <span class="text-[11px] font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-800">Perhatian</span>
            </div>
        </div>

        <!-- Table Daftar Stok Menu -->
        <div class="bg-surface-bright rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div
                class="p-4 bg-surface-container-lowest border-b border-outline-variant/30 flex justify-between items-center">
                <h3 class="font-bold text-sm text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-lg">restaurant_menu</span>
                    Daftar Stok Produk
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-surface-container-high text-on-surface font-bold border-b border-outline-variant/30">
                        <tr>
                            <th class="p-4">Nama Menu</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Harga Satuan</th>
                            <th class="p-4 text-center">Sisa Stok</th>
                            <th class="p-4 text-center">Status Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($products as $prod)
                            @php
                                $stock = $prod['stock'] ?? 0;
                                $isAvailable = ($prod['is_available'] ?? true) && $stock > 0;
                            @endphp
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 font-bold text-on-surface">
                                    {{ $prod['name'] }}
                                    @if (!empty($prod['description']))
                                        <span
                                            class="block text-[10px] text-on-surface-variant font-normal">{{ $prod['description'] }}</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span
                                        class="px-2.5 py-1 rounded-lg bg-surface-container font-bold text-[10px] text-on-surface">
                                        {{ $prod['category']['name'] ?? 'Menu' }}
                                    </span>
                                </td>
                                <td class="p-4 font-bold text-secondary">
                                    Rp {{ number_format($prod['price'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    <span
                                        class="font-mono text-sm font-bold {{ $stock <= 5 ? 'text-red-600' : 'text-on-surface' }}">
                                        {{ $stock }} Porsi
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if ($isAvailable)
                                        <span
                                            class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Tersedia
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Habis
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-on-surface-variant italic">Belum ada data
                                    produk menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
