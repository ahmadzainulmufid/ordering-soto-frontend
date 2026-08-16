@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Soto Lamongan Cak Mufid')

@section('content')
    <div class="px-margin-desktop py-12 flex items-center justify-center min-h-[70vh]">
        <div
            class="bg-surface-bright rounded-2xl p-8 max-w-lg w-full shadow-lg border border-outline-variant/30 text-center">

            <!-- Icon Success -->
            <div class="w-16 h-16 bg-green-100 text-green-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-4xl"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>

            <h1 class="font-headline-md text-headline-md font-bold text-on-surface mb-1">Pesanan Berhasil Dibuat!</h1>
            <p class="text-xs text-on-surface-variant mb-6">Terima kasih, pesanan Anda telah terdaftar di sistem kami.</p>

            <!-- Kode Pesanan Box -->
            <div class="bg-surface-container p-4 rounded-xl mb-6">
                <span class="text-xs text-on-surface-variant block mb-1">Kode Pesanan Anda:</span>
                <span
                    class="font-mono text-2xl font-bold text-primary tracking-wider">{{ $code ?? ($order['order_code'] ?? '-') }}</span>
            </div>

            @if ($order)
                @php
                    $paymentMethod = strtolower($order['payment_method'] ?? request('payment_method', 'cash'));
                    $orderType = strtolower($order['order_type'] ?? 'dine_in');
                    $paymentStatus = strtolower($order['payment_status'] ?? 'unpaid');
                    $isOnlinePayment = in_array($paymentMethod, ['qris', 'online_payment']);
                    $snapToken = $order['snap_token'] ?? null;
                @endphp

                <!-- Rincian Pesanan -->
                <div class="text-left border-t border-b border-outline-variant/30 py-4 mb-6 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Nama Pemesan:</span>
                        <span class="font-bold text-on-surface">{{ $order['customer_name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Tipe Pesanan:</span>
                        <span class="font-bold uppercase text-on-surface">
                            {{ str_replace('_', ' ', $orderType) }}
                            @if ($orderType === 'dine_in' && !empty($order['table_id']))
                                (Meja {{ $order['table_id'] }})
                            @endif
                        </span>
                    </div>

                    @if ($orderType === 'delivery' && !empty($order['delivery_address']))
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant">Alamat Antar:</span>
                            <span
                                class="font-bold text-on-surface text-right max-w-[200px]">{{ $order['delivery_address'] }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Metode Pembayaran:</span>
                        <span class="font-bold uppercase text-primary">
                            {{ $isOnlinePayment ? 'QRIS / MIDTRANS ONLINE' : 'TUNAI / BAYAR DI KASIR' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Status Pembayaran:</span>
                        <span id="paymentStatusBadge"
                            class="px-2 py-0.5 rounded-md font-bold uppercase text-[10px] {{ $paymentStatus === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $paymentStatus === 'paid' ? 'PAID (Lunas)' : 'UNPAID (Menunggu Pembayaran)' }}
                        </span>
                    </div>
                    <div
                        class="flex justify-between pt-2 border-t border-dashed border-outline-variant/30 text-sm font-bold">
                        <span>Total Pembayaran:</span>
                        <span class="text-secondary">Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- PETUNJUK PEMBAYARAN SESUAI METODE -->
                @if ($isOnlinePayment && $paymentStatus !== 'paid')
                    <!-- Pembayaran Online via Midtrans Snap -->
                    <div
                        class="p-5 bg-primary-container/10 border border-primary/30 rounded-2xl text-xs mb-6 text-center space-y-3">
                        <p class="font-bold text-primary text-sm">Pembayaran Online</p>
                        <p class="text-[11px] text-on-surface-variant">
                            Klik tombol di bawah untuk membuka halaman pembayaran QRIS / e-wallet / transfer bank via
                            Midtrans.
                        </p>

                        @if ($snapToken)
                            <button id="btnPayNow" type="button"
                                class="w-full py-3 bg-primary text-white font-bold rounded-xl shadow-md hover:bg-primary/90 active:scale-95 transition-all flex items-center justify-center gap-2 text-xs">
                                <span class="material-symbols-outlined text-sm">qr_code_2</span>
                                Bayar Sekarang
                            </button>
                            <p id="paymentPendingNote" class="text-[10px] text-on-surface-variant italic">
                                Belum bayar? Klik tombol di atas kapan saja sebelum meninggalkan halaman ini.
                            </p>
                        @else
                            <p class="text-[11px] text-red-600 font-bold">
                                Token pembayaran tidak tersedia. Silakan hubungi kasir untuk verifikasi manual.
                            </p>
                        @endif
                    </div>
                @elseif($isOnlinePayment && $paymentStatus === 'paid')
                    <div class="p-4 bg-green-50 text-green-800 rounded-xl text-xs mb-6 flex gap-3 items-start">
                        <span class="material-symbols-outlined text-green-600 shrink-0">check_circle</span>
                        <p>Pembayaran Anda sudah kami terima. Terima kasih!</p>
                    </div>
                @else
                    <!-- Petunjuk Tunai / Cash -->
                    <div
                        class="p-4 bg-secondary-container/30 text-on-secondary-container rounded-xl text-xs mb-6 text-left flex gap-3 items-start">
                        <span class="material-symbols-outlined text-secondary shrink-0">info</span>
                        <div>
                            @if ($orderType === 'dine_in')
                                <p>Tunjukkan <strong>Kode Pesanan</strong> ini ke kasir saat Anda selesai makan untuk
                                    melakukan pembayaran.</p>
                            @elseif($orderType === 'takeaway')
                                <p>Silakan menuju ke area kasir dan tunjukkan Kode Pesanan ini untuk membayar & mengambil
                                    pesanan bungkus Anda.</p>
                            @else
                                <p>Siapkan uang pas sebesar <strong>Rp
                                        {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</strong> untuk dibayarkan
                                    langsung kepada kurir saat pesanan sampai.</p>
                            @endif
                        </div>
                    </div>
                @endif
            @endif

            <a href="{{ route('menu.index') }}"
                class="block w-full py-3 bg-secondary text-white font-bold rounded-xl text-sm shadow-md hover:bg-secondary/90 transition-all">
                Kembali ke Menu Utama
            </a>
        </div>
    </div>

    @if ($order && ($order['snap_token'] ?? null) && strtolower($order['payment_status'] ?? 'unpaid') !== 'paid')
        <script src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('btnPayNow');
                if (!btn) return;

                btn.addEventListener('click', function() {
                    snap.pay('{{ $order['snap_token'] }}', {
                        onSuccess: function(result) {
                            window.location.reload();
                        },
                        onPending: function(result) {
                            alert(
                            'Pembayaran sedang diproses. Silakan selesaikan pembayaran Anda.');
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal. Silakan coba lagi atau hubungi kasir.');
                        },
                        onClose: function() {
                            // User menutup popup tanpa menyelesaikan pembayaran
                        }
                    });
                });
            });
        </script>
    @endif
@endsection
