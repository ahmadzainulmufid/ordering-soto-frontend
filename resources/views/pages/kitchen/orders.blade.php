@extends('layouts.kitchen')

@section('title', 'Kelola Pesanan Dapur - Soto Lamongan Cak Mufid')
@section('header_title', 'Antrean Dapur')

@section('content')

    <!-- Flash Alert Status Update -->
    @if (session('success'))
        <div id="alert-success"
            class="bg-secondary-container text-on-secondary-container p-4 rounded-2xl border border-secondary/30 flex items-center justify-between shadow-sm animate-fade-in mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary text-2xl"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div>
                    <h4 class="font-label-md font-bold">Berhasil!</h4>
                    <p class="text-xs text-on-secondary-container/80">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="p-1 hover:bg-secondary/10 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="bg-red-100 text-red-800 p-4 rounded-2xl border border-red-200 flex items-center justify-between shadow-sm animate-fade-in mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600 text-2xl">error</span>
                <div>
                    <h4 class="font-label-md font-bold">Terjadi Kesalahan!</h4>
                    <p class="text-xs text-red-700">{{ session('error') }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('alert-error').remove()"
                class="p-1 hover:bg-red-200 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    @php
        // Map data produk & meja berdasarkan ID untuk lookup yang cepat
        $productsMap = collect($products ?? [])->keyBy('id');
        $tablesMap = collect($tables ?? [])->keyBy('id');

        // Filter pesanan khusus dapur (Pending, Cooking, Confirmed)
        $kitchenOrders = collect($orders ?? [])->filter(function ($ord) {
            $st = strtolower($ord['status'] ?? '');
            return in_array($st, ['pending', 'confirmed', 'cooking']);
        });

        // Hitung total counter tiap status untuk Badge Filter
        $pendingCount = $kitchenOrders
            ->filter(fn($o) => in_array(strtolower($o['status'] ?? ''), ['pending', 'confirmed']))
            ->count();
        $cookingCount = $kitchenOrders->filter(fn($o) => strtolower($o['status'] ?? '') === 'cooking')->count();
    @endphp

    <!-- Header Section & Filter Tabs -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="font-headline-lg text-2xl font-bold text-on-surface">Monitoring Sajian Dapur</h1>
            <p class="text-xs text-on-surface-variant">Utamakan pesanan dengan indikator warna merah (Baru Masuk)</p>
        </div>

        <!-- Filter Tab Status -->
        <div
            class="flex items-center gap-2 bg-surface-container p-1.5 rounded-2xl border border-outline-variant/30 overflow-x-auto w-full md:w-auto">
            <button onclick="filterKitchen('all')" id="tab-all"
                class="kitchen-tab px-4 py-2 rounded-xl text-xs font-bold bg-primary text-white shadow-sm transition-all">
                Semua Antrean
            </button>
            <button onclick="filterKitchen('pending')" id="tab-pending"
                class="kitchen-tab px-4 py-2 rounded-xl text-xs font-bold text-on-surface-variant hover:bg-surface-container-high transition-all flex items-center gap-1.5">
                <span>Pesanan Baru</span>
                <span
                    class="px-2 py-0.5 rounded-full bg-red-500 text-white text-[10px] font-bold">{{ $pendingCount }}</span>
            </button>
            <button onclick="filterKitchen('cooking')" id="tab-cooking"
                class="kitchen-tab px-4 py-2 rounded-xl text-xs font-bold text-on-surface-variant hover:bg-surface-container-high transition-all flex items-center gap-1.5">
                <span>Sedang Dimasak</span>
                <span
                    class="px-2 py-0.5 rounded-full bg-amber-500 text-white text-[10px] font-bold">{{ $cookingCount }}</span>
            </button>
        </div>
    </div>

    <!-- Grid Card Antrean Pesanan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 items-start" id="kitchenGrid">

        @forelse ($kitchenOrders as $ord)
            @php
                $rawStatus = strtolower($ord['status'] ?? 'pending');
                $isPending = in_array($rawStatus, ['pending', 'confirmed']);
                $dataStatus = $isPending ? 'pending' : 'cooking';

                // Format Meja / Tipe Pesanan
                $orderTypeRaw = strtolower($ord['order_type'] ?? 'dine_in');
                $tableNumber =
                    isset($ord['table_id']) && isset($tablesMap[$ord['table_id']])
                        ? $tablesMap[$ord['table_id']]['table_number']
                        : null;

                $locationLabel = match ($orderTypeRaw) {
                    'dine_in' => $tableNumber ? "Meja {$tableNumber}" : 'Dine In',
                    'takeaway' => 'Takeaway',
                    'delivery' => 'Delivery',
                    default => strtoupper($orderTypeRaw),
                };

                // Styling Card sesuai Status
                $borderColor = $isPending ? 'border-red-400' : 'border-amber-400';
                $headerBg = $isPending ? 'bg-red-50 border-red-100' : 'bg-amber-50 border-amber-100';
                $badgeTypeColor = $isPending ? 'text-red-700 bg-red-100' : 'text-amber-900 bg-amber-100';
                $statusTextColor = $isPending ? 'text-red-600' : 'text-amber-700';
                $statusText = $isPending ? 'Baru Masuk' : 'Proses Kompor';
            @endphp

            <div class="kitchen-card bg-surface-bright rounded-2xl shadow-sm border-2 {{ $borderColor }} overflow-hidden flex flex-col"
                data-status="{{ $dataStatus }}">

                <!-- Card Header -->
                <div class="p-4 {{ $headerBg }} border-b flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-base text-on-surface font-mono">
                            {{ $ord['order_code'] ?? '#ORD-' . $ord['id'] }}</h3>
                        <span class="text-[10px] font-bold uppercase {{ $badgeTypeColor }} px-2 py-0.5 rounded-md">
                            {{ $locationLabel }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-xs font-bold {{ $statusTextColor }} flex items-center gap-1 justify-end {{ $isPending ? 'animate-pulse' : '' }}">
                            @if ($isPending)
                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                            @endif
                            {{ $statusText }}
                        </span>
                        <span class="text-[11px] font-mono text-on-surface-variant">
                            {{ isset($ord['created_at']) ? date('H:i', strtotime($ord['created_at'])) . ' WIB' : '-' }}
                        </span>
                    </div>
                </div>

                <!-- Card Body: Detail Pesanan -->
                <div class="p-4 space-y-3 grow">
                    <!-- Iterasi Items Pesanan -->
                    @php $items = $ord['items'] ?? []; @endphp
                    @foreach ($items as $index => $item)
                        @php
                            $prodId = $item['product_id'] ?? null;
                            $prodName = $item['product_name'] ?? ($productsMap[$prodId]['name'] ?? 'Menu #' . $prodId);
                            $qty = $item['quantity'] ?? 1;
                        @endphp

                        <div class="space-y-1">
                            <div class="flex justify-between items-start text-sm">
                                <span class="font-bold text-on-surface">{{ $qty }}x {{ $prodName }}</span>
                                <span class="font-bold text-primary font-mono text-sm">{{ $qty }} Porsi</span>
                            </div>

                            <!-- Catatan per Item jika ada -->
                            @if (!empty($item['notes']))
                                <p class="text-[11px] text-on-surface-variant italic pl-3 border-l-2 border-primary/40">
                                    Catatan item: {{ $item['notes'] }}
                                </p>
                            @endif
                        </div>

                        @if (!$loop->last)
                            <hr class="border-dashed border-outline-variant/30">
                        @endif
                    @endforeach

                    <!-- Highlight Catatan Utama Pesanan (Global Notes) -->
                    @if (!empty($ord['notes']))
                        <div
                            class="mt-3 p-2.5 bg-red-100/60 rounded-xl border border-red-200 text-xs text-red-900 font-semibold space-y-0.5">
                            <div class="flex items-center gap-1 text-red-700 font-bold">
                                <span class="material-symbols-outlined text-sm">sticky_note_2</span>
                                <span>Catatan Pelanggan:</span>
                            </div>
                            <p class="pl-5 text-[11px]">{{ $ord['notes'] }}</p>
                        </div>
                    @endif
                </div>

                <!-- Card Action Footer -->
                <div class="p-3 bg-surface-container-lowest border-t border-outline-variant/20">
                    <form action="{{ route('kitchen.orders.updateStatus', $ord['id']) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        @if ($isPending)
                            <input type="hidden" name="status" value="cooking">
                            <button type="submit"
                                class="w-full py-3 bg-amber-500 hover:bg-amber-600 active:scale-95 text-white font-bold text-xs uppercase rounded-xl shadow transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">skillet</span> Mulai Masak
                            </button>
                        @else
                            <input type="hidden" name="status" value="ready">
                            <button type="submit"
                                class="w-full py-3 bg-secondary hover:bg-secondary/90 active:scale-95 text-white font-bold text-xs uppercase rounded-xl shadow transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">check_circle</span> Sajikan / Ready
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        @empty
            <!-- Tampilan Kosong (Empty State) saat tidak ada antrean pesanan dari API -->
            <div id="emptyKitchenState"
                class="col-span-full text-center py-20 bg-surface-bright rounded-2xl border border-dashed border-outline-variant/40">
                <span class="material-symbols-outlined text-6xl text-outline/30 mb-2">done_all</span>
                <h3 class="font-bold text-base text-on-surface">Semua Pesanan Selesai!</h3>
                <p class="text-xs text-on-surface-variant">Tidak ada antrean masakan aktif saat ini.</p>
            </div>
        @endforelse

        <!-- Container Jaga-jaga untuk Filter JavaScript JS jika antrean disaring habis -->
        <div id="emptyFilterState"
            class="hidden col-span-full text-center py-20 bg-surface-bright rounded-2xl border border-dashed border-outline-variant/40">
            <span class="material-symbols-outlined text-6xl text-outline/30 mb-2">filter_alt_off</span>
            <h3 class="font-bold text-base text-on-surface">Tidak Ada Pesanan Pada Kategori Ini</h3>
            <p class="text-xs text-on-surface-variant">Pilih tab filter lain untuk melihat antrean.</p>
        </div>

    </div>

    <!-- Script Tab Filter & Auto Alert Close -->
    <script>
        function filterKitchen(status) {
            const tabs = document.querySelectorAll('.kitchen-tab');
            tabs.forEach(tab => {
                tab.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                tab.classList.add('text-on-surface-variant');
            });

            const activeTab = document.getElementById(`tab-${status}`);
            if (activeTab) {
                activeTab.classList.remove('text-on-surface-variant');
                activeTab.classList.add('bg-primary', 'text-white', 'shadow-sm');
            }

            const cards = document.querySelectorAll('.kitchen-card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyFilterState = document.getElementById('emptyFilterState');
            if (emptyFilterState) {
                if (visibleCount === 0 && cards.length > 0) {
                    emptyFilterState.classList.remove('hidden');
                } else {
                    emptyFilterState.classList.add('hidden');
                }
            }
        }

        // Auto Dismiss Alert
        setTimeout(() => {
            const successAlert = document.getElementById('alert-success');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
            const errorAlert = document.getElementById('alert-error');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 4000);
    </script>
@endsection
