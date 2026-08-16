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
                @endphp

                <!-- Rincian Pesanan -->
                <div class="text-left border-t border-b border-outline-variant/30 py-4 mb-6 space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Nama Pemesan:</span>
                        <span class="font-bold text-on-surface">{{ $order['customer_name'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Tipe Pesanan:</span>
                        <span
                            class="font-bold uppercase text-on-surface">{{ str_replace('_', ' ', $order['order_type']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Metode Pembayaran:</span>
                        <span class="font-bold uppercase text-primary">
                            @if ($paymentMethod === 'online_payment')
                                MIDTRANS (ONLINE PAYMENT)
                            @else
                                BAYAR DI KASIR (CASH)
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Status Pesanan:</span>
                        <span class="px-2 py-0.5 rounded-md font-bold bg-yellow-100 text-yellow-800 uppercase text-[10px]">
                            {{ $order['status'] ?? 'PENDING' }}
                        </span>
                    </div>
                    <div
                        class="flex justify-between pt-2 border-t border-dashed border-outline-variant/30 text-sm font-bold">
                        <span>Total Pembayaran:</span>
                        <span class="text-secondary">Rp {{ number_format($order['total'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- OPSI PEMBAYARAN ONLINE MIDTRANS -->
                @if ($paymentMethod === 'online_payment')
                    <div
                        class="p-5 bg-primary-container/20 border border-primary/30 rounded-2xl text-xs mb-6 text-left flex flex-col gap-3">
                        <div class="flex items-center gap-2 font-bold text-sm text-primary">
                            <span class="material-symbols-outlined">credit_card</span>
                            <span>Pembayaran Online via Midtrans</span>
                        </div>
                        <p class="text-on-surface-variant">
                            Klik tombol di bawah untuk membayar menggunakan <strong>QRIS, GoPay, ShopeePay, Virtual Account
                                (BCA, Mandiri, BRI)</strong>, atau Kartu Kredit.
                        </p>

                        <button id="pay-button"
                            class="w-full py-3.5 bg-primary text-white font-bold rounded-xl shadow-lg hover:bg-primary/90 active:scale-95 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">lock</span> Bayar Sekarang (Midtrans)
                        </button>
                    </div>

                    <!-- OPSI DEFAULT: BAYAR DI KASIR -->
                @else
                    <div
                        class="p-4 bg-secondary-container/30 text-on-secondary-container rounded-xl text-xs mb-6 text-left flex gap-3 items-start">
                        <span class="material-symbols-outlined text-secondary shrink-0">info</span>
                        <p>Tunjukkan <strong>Kode Pesanan</strong> ini ke kasir untuk melakukan pembayaran secara langsung.
                        </p>
                    </div>
                @endif

            @endif

            <a href="{{ route('menu.index') }}"
                class="block w-full py-3 bg-secondary text-white font-bold rounded-xl text-sm shadow-md hover:bg-secondary/90 transition-all">
                Kembali ke Menu Utama
            </a>
        </div>
    </div>

    <!-- Integration Midtrans Snap JS -->
    @if (isset($snapToken) && $snapToken != '')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>
        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.onclick = function() {
                    snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil!');
                            location.reload();
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran Anda.');
                            location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal atau dibatalkan.');
                        },
                        onClose: function() {
                            alert('Anda menutup jendela pembayaran sebelum menyelesaikan transaksi.');
                        }
                    });
                };
            }
        </script>
    @endif
@endsection
