@extends('layouts.owner')

@section('title', 'Pesanan Masuk - Owner Panel')
@section('header_title', 'Pesanan Masuk')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-on-surface">Daftar Pesanan Masuk</h2>
                <p class="text-xs text-on-surface-variant">Pantau seluruh transaksi dan ubah status pemrosesan soto.</p>
            </div>
        </div>

        <!-- Table Orders -->
        <div class="bg-surface-bright rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-surface-container-high text-on-surface font-bold border-b border-outline-variant/30">
                        <tr>
                            <th class="p-4">Kode Order</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Tipe / Meja</th>
                            <th class="p-4">Detail Items</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="p-4 font-mono font-bold text-primary">{{ $order['order_code'] }}</td>
                                <td class="p-4 font-bold">
                                    {{ $order['customer_name'] }}
                                    <span
                                        class="block text-[10px] text-on-surface-variant font-normal">{{ $order['customer_phone'] ?? '-' }}</span>
                                </td>
                                <td class="p-4">
                                    <span
                                        class="uppercase font-bold text-[10px] px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                        {{ str_replace('_', ' ', $order['order_type']) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <ul class="space-y-0.5">
                                        @foreach ($order['items'] ?? [] as $item)
                                            <li>• {{ $item['quantity'] }}x {{ $item['product_name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="p-4 font-bold text-secondary">Rp
                                    {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</td>
                                <td class="p-4">
                                    @php
                                        $badge = match ($order['status'] ?? '') {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'cooking' => 'bg-orange-100 text-orange-800',
                                            'ready' => 'bg-purple-100 text-purple-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 rounded-full font-bold text-[10px] uppercase {{ $badge }}">
                                        {{ $order['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-on-surface-variant italic">Belum ada pesanan
                                    masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
