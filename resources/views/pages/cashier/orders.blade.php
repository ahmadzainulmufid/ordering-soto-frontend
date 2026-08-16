@extends('layouts.cashier')

@section('title', 'Kelola Pesanan - Kasir Panel')
@section('header_title', 'Kelola & Pemesanan Kasir')

@section('content')
    <div class="space-y-6">

        <!-- Flash Notification -->
        @if (session('success'))
            <div id="alert-success"
                class="bg-secondary-container text-on-secondary-container p-4 rounded-2xl border border-secondary/30 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary text-2xl">check_circle</span>
                    <p class="text-xs font-bold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="p-1"><span
                        class="material-symbols-outlined text-sm">close</span></button>
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error"
                class="bg-error-container text-on-error-container p-4 rounded-2xl border border-error/30 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-error text-2xl">error</span>
                    <p class="text-xs font-bold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="p-1"><span
                        class="material-symbols-outlined text-sm">close</span></button>
            </div>
        @endif

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-on-surface">Manajemen Pesanan Resto</h2>
                <p class="text-xs text-on-surface-variant">Setujui pembayaran kasir dari web dan catat pemesanan manual
                    secara instan.</p>
            </div>
            <button onclick="openManualOrderModal()"
                class="px-5 py-3 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-2 text-xs">
                <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                + Buat Pesanan Manual Kasir
            </button>
        </div>

        <!-- Orders Table -->
        <div class="bg-surface-bright rounded-2xl shadow-sm border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-surface-container-high text-on-surface font-bold border-b border-outline-variant/30">
                        <tr>
                            <th class="p-4">Kode Order</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Tipe / Meja</th>
                            <th class="p-4">Detail Items</th>
                            <th class="p-4">Metode Bayar</th>
                            <th class="p-4">Total</th>
                            <th class="p-4">Status Order</th>
                            <th class="p-4 text-center">Aksi / Verifikasi Kasir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse ($orders as $order)
                            @php
                                $paymentMethod = strtolower($order['payment_method'] ?? 'cash');
                                $paymentStatus = strtolower($order['payment_status'] ?? 'unpaid');
                                $isCashierPayPending =
                                    in_array($paymentMethod, ['cash', 'bayar_di_kasir']) && $paymentStatus === 'unpaid';
                            @endphp
                            <tr
                                class="hover:bg-surface-container-low transition-colors {{ $isCashierPayPending ? 'bg-amber-500/5' : '' }}">
                                <!-- Kode Order -->
                                <td class="p-4 font-mono font-bold text-primary">
                                    {{ $order['order_code'] }}
                                    <span class="block text-[10px] text-on-surface-variant font-normal">
                                        {{ date('H:i, d M', strtotime($order['created_at'] ?? 'now')) }}
                                    </span>
                                </td>

                                <!-- Pelanggan -->
                                <td class="p-4 font-bold">
                                    {{ $order['customer_name'] }}
                                    <span
                                        class="block text-[10px] text-on-surface-variant font-normal">{{ $order['customer_phone'] ?? '-' }}</span>
                                </td>

                                <!-- Tipe / Meja -->
                                <td class="p-4">
                                    <span
                                        class="uppercase font-bold text-[10px] px-2 py-0.5 rounded bg-surface-container text-on-surface">
                                        {{ str_replace('_', ' ', $order['order_type'] ?? 'dine_in') }}
                                    </span>
                                    @if (!empty($order['table_id']) || !empty($order['table']))
                                        <span class="block text-[10px] text-primary font-bold mt-0.5">
                                            Meja
                                            {{ is_array($order['table'] ?? null) ? $order['table']['table_number'] ?? ($order['table']['name'] ?? '-') : $order['table_id'] ?? '-' }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Detail Items -->
                                <td class="p-4">
                                    <ul class="space-y-0.5">
                                        @foreach ($order['items'] ?? [] as $item)
                                            <li>• {{ $item['quantity'] }}x {{ $item['product_name'] }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- Metode Pembayaran -->
                                <td class="p-4">
                                    @if (in_array($paymentMethod, ['cash', 'bayar_di_kasir']))
                                        <span
                                            class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-bold text-[10px] uppercase flex items-center gap-1 w-max">
                                            <span class="material-symbols-outlined text-xs">payments</span> Bayar di Kasir
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 font-bold text-[10px] uppercase flex items-center gap-1 w-max">
                                            <span class="material-symbols-outlined text-xs">credit_card</span> Midtrans
                                            Online
                                        </span>
                                    @endif

                                    <span
                                        class="block text-[10px] font-bold mt-1 {{ $paymentStatus === 'paid' ? 'text-green-600' : 'text-red-500' }}">
                                        ● {{ strtoupper($paymentStatus) }}
                                    </span>
                                </td>

                                <!-- Total -->
                                <td class="p-4 font-bold text-secondary">Rp
                                    {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</td>

                                <!-- Status Pesanan -->
                                <td class="p-4">
                                    @php
                                        $badge = match (strtolower($order['status'] ?? '')) {
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

                                <!-- Aksi Kasir -->
                                <td class="p-4 text-center">
                                    <div class="flex flex-col gap-2 items-center">
                                        @if ($isCashierPayPending)
                                            <form action="{{ route('cashier.orders.confirm-pay', $order['id']) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold text-[10px] shadow-sm flex items-center gap-1 transition-all">
                                                    <span class="material-symbols-outlined text-xs">check_circle</span>
                                                    Setujui Pembayaran
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('cashier.orders.update-status', $order['id']) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()"
                                                class="text-[11px] p-1.5 bg-surface-container rounded-lg border border-outline-variant font-bold cursor-pointer outline-none">
                                                <option value="pending"
                                                    {{ $order['status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed"
                                                    {{ $order['status'] == 'confirmed' ? 'selected' : '' }}>Konfirmasi
                                                </option>
                                                <option value="cooking"
                                                    {{ $order['status'] == 'cooking' ? 'selected' : '' }}>Memasak</option>
                                                <option value="ready" {{ $order['status'] == 'ready' ? 'selected' : '' }}>
                                                    Siap Saji</option>
                                                <option value="completed"
                                                    {{ $order['status'] == 'completed' ? 'selected' : '' }}>Selesai
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-on-surface-variant italic">Belum ada pesanan
                                    masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL PEMESANAN MANUAL KASIR (POS) -->
    <div id="manualOrderModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-surface-bright rounded-2xl max-w-2xl w-full p-6 space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center border-b border-outline-variant/30 pb-3">
                <h3 class="font-bold text-lg text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">point_of_sale</span>
                    Buat Pesanan Manual Kasir
                </h3>
                <button onclick="closeManualOrderModal()" class="text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('cashier.orders.store-manual') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold mb-1">Nama Pelanggan *</label>
                        <input type="text" name="customer_name" required placeholder="Contoh: Pak Budi"
                            class="w-full p-2.5 bg-surface-container rounded-xl text-xs outline-none border border-outline-variant">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="customer_phone" placeholder="08123456789"
                            class="w-full p-2.5 bg-surface-container rounded-xl text-xs outline-none border border-outline-variant">
                    </div>
                    <div>
                        <label class="block text-xs font-bold mb-1">Tipe Pesanan *</label>
                        <select id="orderTypeSelect" name="order_type" required
                            class="w-full p-2.5 bg-surface-container rounded-xl text-xs font-bold outline-none border border-outline-variant">
                            <option value="dine_in" selected>Dine In (Makan di Tempat)</option>
                            <option value="takeaway">Takeaway (Bungkus)</option>
                            <option value="delivery">Delivery (Antar)</option>
                        </select>
                    </div>

                    <!-- Field Pilih Meja (Tampil secara default untuk Dine In) -->
                    <div id="tableField">
                        <label class="block text-xs font-bold mb-1">Pilih Nomor Meja *</label>
                        <select name="table_id"
                            class="w-full p-2.5 bg-surface-container rounded-xl text-xs outline-none border border-outline-variant font-bold">
                            <option value="" disabled selected>-- Pilih Meja --</option>
                            @forelse ($tables ?? [] as $table)
                                @if (($table['is_active'] ?? false) == true || ($table['is_active'] ?? 0) == 1)
                                    <option value="{{ $table['id'] }}">
                                        {{ $table['table_number'] ?? 'Meja ' . $table['id'] }}
                                    </option>
                                @endif
                            @empty
                                <option value="" disabled>Belum ada meja yang terdaftar</option>
                            @endforelse
                        </select>
                    </div>

                    <!-- Field Alamat Pengiriman (Sembunyi secara default, Tampil saat Delivery) -->
                    <div id="addressField" class="hidden md:col-span-2">
                        <label class="block text-xs font-bold mb-1">Alamat Pengiriman *</label>
                        <textarea name="delivery_address" rows="2" placeholder="Alamat lengkap lokasi pengiriman..."
                            class="w-full p-2.5 bg-surface-container rounded-xl text-xs outline-none border border-outline-variant"></textarea>
                    </div>
                </div>

                <input type="hidden" name="payment_method" value="cash">

                <!-- Dynamic Product Selection -->
                <div class="border-t border-outline-variant/30 pt-3">
                    <label class="block text-xs font-bold mb-2">Pilih Menu Pesanan *</label>
                    <div id="itemsContainer" class="space-y-2">
                        <div class="flex gap-2 items-center item-row">
                            <select name="items[0][id]" required
                                class="grow p-2.5 bg-surface-container rounded-xl text-xs outline-none border border-outline-variant">
                                <option value="">-- Pilih Produk Menu --</option>
                                @foreach ($products as $prod)
                                    <option value="{{ $prod['id'] }}">
                                        {{ $prod['name'] }} - Rp {{ number_format($prod['price'] ?? 0, 0, ',', '.') }}
                                        (Stok: {{ $prod['stock'] ?? 0 }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="items[0][qty]" value="1" min="1" required
                                placeholder="Qty"
                                class="w-20 p-2.5 bg-surface-container rounded-xl text-xs text-center outline-none border border-outline-variant font-bold">
                            <button type="button" onclick="removeItemRow(this)"
                                class="p-2 text-red-500 hover:bg-red-50 rounded-xl">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="addItemRow()"
                        class="mt-2 text-xs text-primary font-bold flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-sm">add</span> Tambah Baris Menu Lain
                    </button>
                </div>

                <div class="pt-4 border-t border-outline-variant/30 flex justify-end gap-3">
                    <button type="button" onclick="closeManualOrderModal()"
                        class="px-4 py-2.5 bg-surface-container text-on-surface rounded-xl text-xs font-bold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-primary text-white rounded-xl text-xs font-bold hover:bg-primary/90">
                        Proses Pesanan Kasir
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
