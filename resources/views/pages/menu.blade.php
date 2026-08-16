@extends('layouts.app')

@section('title', 'Menu - Soto Lamongan Cak Mufid')

@section('content')
    <div class="px-margin-desktop py-12">
        <!-- Flash Alert Error -->
        @if (session('error'))
            <div
                class="bg-red-100 text-red-800 p-4 rounded-2xl border border-red-200 flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-600">error</span>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="p-1 hover:bg-red-200 rounded-lg">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Header Section -->
        <header class="mb-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <h1 class="font-headline-lg text-headline-lg text-primary mb-2">Menu Kami</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                        Nikmati kelezatan Soto Lamongan otentik dengan koya gurih dan pilihan sate pelengkap terbaik dari
                        dapur Cak Mufid.
                    </p>
                </div>
                <!-- Search Input Bar -->
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline"
                        data-icon="search">search</span>
                    <input id="searchInput" onkeyup="searchMenu()"
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border-none focus:ring-2 focus:ring-primary-container font-body-md text-body-md outline-none"
                        placeholder="Cari menu favorit Anda..." type="text" />
                </div>
            </div>

            <!-- Category Filters Dinamis -->
            <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto custom-scrollbar pb-1 md:pb-0">
                <button onclick="filterCategory('all')" id="tab-all"
                    class="category-tab px-4 py-2 rounded-xl text-xs font-bold bg-primary-container text-on-primary-container shadow-sm whitespace-nowrap">
                    Semua Menu
                </button>

                @foreach ($categories as $cat)
                    @if (($cat['is_active'] ?? false) == true || ($cat['is_active'] ?? 0) == 1)
                        <button onclick="filterCategory('{{ $cat['id'] }}')" id="tab-{{ $cat['id'] }}"
                            class="category-tab px-4 py-2 rounded-xl text-xs font-bold bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors whitespace-nowrap">
                            {{ $cat['name'] }}
                        </button>
                    @endif
                @endforeach
            </div>
        </header>

        <!-- Layout Grid -->
        <div class="grid grid-cols-12 gap-gutter">
            <!-- Left: Menu Grid (9 cols) -->
            <section class="col-span-12 lg:col-span-9">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter" id="menuGrid">

                    @forelse ($products as $item)
                        <!-- Hanya tampilkan produk yang is_available bernilai true / 1 -->
                        @if (($item['is_available'] ?? false) == true || ($item['is_available'] ?? 0) == 1)
                            <div class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col hover:shadow-md transition-shadow"
                                data-category-id="{{ $item['category_id'] ?? '' }}"
                                data-name="{{ strtolower($item['name'] ?? '') }}">

                                <div
                                    class="h-48 w-full overflow-hidden bg-surface-container-high flex items-center justify-center">
                                    @if (!empty($item['image_url']))
                                        <img class="w-full h-full object-cover" src="{{ $item['image_url'] }}"
                                            alt="{{ $item['name'] }}" />
                                    @else
                                        <span class="material-symbols-outlined text-5xl text-outline/40">restaurant</span>
                                    @endif
                                </div>

                                <div class="p-5 grow flex flex-col">
                                    <div class="flex justify-between items-start mb-2 gap-2">
                                        <h3 class="font-title-md text-title-md text-on-surface font-bold">
                                            {{ $item['name'] }}</h3>
                                        <span class="font-label-md text-label-md text-secondary font-bold shrink-0">
                                            Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="font-body-md text-xs text-on-surface-variant mb-6 line-clamp-2">
                                        {{ $item['description'] ?? 'Sajian gurih & lezat khas Soto Lamongan Cak Mufid.' }}
                                    </p>
                                    <button onclick="addToCart({{ json_encode($item) }})"
                                        class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:scale-95 transition-all">
                                        <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                                    </button>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-span-full text-center py-12 text-on-surface-variant">
                            <span class="material-symbols-outlined text-5xl mb-2 text-outline/40">soup_kitchen</span>
                            <p class="font-bold">Tidak ada menu yang tersedia saat ini.</p>
                        </div>
                    @endforelse

                </div>
            </section>

            <!-- Right: Sticky Cart Summary (3 cols) -->
            <aside class="col-span-12 lg:col-span-3">
                <div class="sticky top-28 bg-surface-container-high rounded-2xl p-6 shadow-md flex flex-col h-fit">
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined" data-icon="shopping_basket">shopping_basket</span>
                        <h2 class="font-title-md text-title-md font-bold">Ringkasan Pesanan</h2>
                    </div>

                    <!-- Selected Items List -->
                    <div id="cartItemsList" class="space-y-4 mb-8 max-h-80 overflow-y-auto custom-scrollbar pr-2">
                        <p id="emptyCartText" class="text-xs text-on-surface-variant italic text-center py-4">Belum ada item
                            dipilih.</p>
                    </div>

                    <!-- Pricing Info -->
                    <div class="border-t border-outline-variant pt-6 space-y-3 mb-8">
                        <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
                            <span>Subtotal</span>
                            <span id="cartSubtotal">Rp 0</span>
                        </div>
                        <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
                            <span>Biaya Layanan</span>
                            <span id="cartServiceFee">Rp 2.000</span>
                        </div>
                        <div
                            class="flex justify-between font-title-md text-title-md text-on-surface pt-2 border-t border-dashed border-outline-variant font-bold">
                            <span>Total</span>
                            <span class="text-secondary" id="cartTotal">Rp 0</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button id="btnCheckout" onclick="openCheckoutModal()" disabled
                        class="w-full py-4 bg-primary-container text-on-primary-container font-label-md text-label-md font-bold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 opacity-50 cursor-not-allowed">
                        Lanjut ke Checkout
                        <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                    </button>
                    <p class="mt-4 text-center text-xs text-on-surface-variant italic">
                        Pesanan akan segera diproses setelah konfirmasi.
                    </p>
                </div>
            </aside>
        </div>
    </div>

    <!-- MODAL FORM CHECKOUT PELANGGAN -->
    <div id="checkoutModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden p-4 overflow-y-auto">
        <div
            class="bg-surface-bright rounded-2xl p-6 max-w-md w-full my-auto shadow-2xl border border-outline-variant/30 max-h-[90vh] flex flex-col">

            <!-- Modal Header (Fixed) -->
            <div class="flex justify-between items-center mb-4 shrink-0">
                <h3 class="font-title-md text-title-md font-bold text-on-surface">Informasi Pemesan</h3>
                <button onclick="closeCheckoutModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Form Body (Scrollable) -->
            <form id="orderForm" action="{{ route('orders.store') }}" method="POST"
                class="space-y-4 overflow-y-auto pr-1 custom-scrollbar">
                @csrf
                <!-- Input JSON Items Hidden untuk Dikirim ke Backend -->
                <input type="hidden" name="items_json" id="itemsJsonInput">

                <div>
                    <label class="block text-xs font-bold mb-1">Nama Lengkap</label>
                    <input type="text" name="customer_name" required placeholder="Masukkan nama Anda"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">No. WhatsApp / Telepon</label>
                    <input type="tel" name="customer_phone" placeholder="08123456789"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Tipe Pesanan</label>
                    <select name="order_type" id="orderTypeSelect" onchange="toggleOrderFields()" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                        <option value="dine_in">Makan di Tempat (Dine In)</option>
                        <option value="takeaway">Bawa Pulang (Takeaway)</option>
                        <option value="delivery">Pesan Antar (Delivery)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Metode Pembayaran</label>
                    <select name="payment_method" id="userPaymentMethod" onchange="togglePaymentInstructions()" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container font-bold">
                        <option value="cash" selected>Bayar di Kasir (Tunai / Cash)</option>
                        <option value="qris">QRIS / E-Wallet / Transfer Bank (Midtrans Online)</option>
                    </select>
                </div>

                <div id="qrisInfoBox"
                    class="hidden p-3 bg-primary-container/20 border border-primary/30 rounded-xl text-xs space-y-2">
                    <div class="flex items-center gap-2 font-bold text-primary">
                        <span class="material-symbols-outlined text-base">qr_code_2</span>
                        <span>Pembayaran Online via Midtrans</span>
                    </div>
                    <p class="text-on-surface-variant text-[11px]">
                        Setelah pesanan dibuat, Anda akan diarahkan ke halaman konfirmasi berisi tombol
                        <strong>"Bayar Sekarang"</strong>. Klik tombol tersebut untuk membuka jendela pembayaran Midtrans
                        (QRIS, GoPay, OVO, Dana, ShopeePay, atau Virtual Account Bank).
                    </p>
                </div>

                <!-- Field Nomor Meja (Tampil saat Dine In) -->
                <div id="tableField">
                    <label class="block text-xs font-bold mb-1">Pilih Nomor Meja</label>
                    <select name="table_id"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
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

                <!-- Field Alamat Pengiriman (Tampil saat Delivery) -->
                <div id="addressField" class="hidden">
                    <label class="block text-xs font-bold mb-1">Alamat Pengiriman</label>
                    <textarea name="delivery_address" rows="2" placeholder="Alamat lengkap lokasi Anda"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold mb-1">Catatan Pesanan (Opsional)</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Koya dibanyakin, soto tanpa tauge"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container"></textarea>
                </div>

                <div class="flex gap-3 pt-2 sticky bottom-0 bg-surface-bright pb-1">
                    <button type="button" onclick="closeCheckoutModal()"
                        class="flex-1 py-3 border border-outline-variant rounded-xl font-bold text-sm">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-secondary text-white font-bold text-sm rounded-xl shadow-md">Buat
                        Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Handlers -->
    <script>
        let cart = [];
        const serviceFee = 2000;

        // Filter Kategori Tab
        function filterCategory(categoryId) {
            const tabs = document.querySelectorAll('.category-tab');
            tabs.forEach(tab => {
                tab.classList.remove('bg-primary-container', 'text-on-primary-container', 'shadow-sm');
                tab.classList.add('bg-surface-container', 'text-on-surface-variant');
            });

            const activeTab = document.getElementById(`tab-${categoryId}`);
            if (activeTab) {
                activeTab.classList.remove('bg-surface-container', 'text-on-surface-variant');
                activeTab.classList.add('bg-primary-container', 'text-on-primary-container', 'shadow-sm');
            }

            const cards = document.querySelectorAll('.menu-card');
            cards.forEach(card => {
                if (categoryId === 'all' || card.getAttribute('data-category-id') === String(categoryId)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Live Search Input Filter
        function searchMenu() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.menu-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                if (name.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Logika Keranjang Belanja (Cart)
        function addToCart(product) {
            const existing = cart.find(item => item.id === product.id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    qty: 1
                });
            }
            renderCart();
        }

        function updateQty(id, delta) {
            const item = cart.find(i => i.id === id);
            if (item) {
                item.qty += delta;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                }
            }
            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cartItemsList');
            const subtotalEl = document.getElementById('cartSubtotal');
            const totalEl = document.getElementById('cartTotal');
            const btnCheckout = document.getElementById('btnCheckout');

            if (cart.length === 0) {
                container.innerHTML =
                    `<p id="emptyCartText" class="text-xs text-on-surface-variant italic text-center py-4">Belum ada item dipilih.</p>`;
                subtotalEl.innerText = 'Rp 0';
                totalEl.innerText = 'Rp 0';
                btnCheckout.disabled = true;
                btnCheckout.classList.add('opacity-50', 'cursor-not-allowed');
                return;
            }

            let subtotal = 0;
            let html = '';

            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                subtotal += itemTotal;

                html += `
                <div class="flex justify-between items-start gap-4">
                    <div class="grow">
                        <h4 class="font-label-md text-label-md text-on-surface font-bold">${item.name}</h4>
                        <div class="flex items-center gap-3 mt-1">
                            <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                <span class="material-symbols-outlined text-xs">remove</span>
                            </button>
                            <span class="font-label-md text-label-md font-bold">${item.qty}</span>
                            <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                <span class="material-symbols-outlined text-xs">add</span>
                            </button>
                        </div>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface whitespace-nowrap font-bold">Rp ${itemTotal.toLocaleString('id-ID')}</span>
                </div>`;
            });

            container.innerHTML = html;
            subtotalEl.innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
            totalEl.innerText = `Rp ${(subtotal + serviceFee).toLocaleString('id-ID')}`;

            btnCheckout.disabled = false;
            btnCheckout.classList.remove('opacity-50', 'cursor-not-allowed');
        }

        // Modal Checkout Handlers
        function openCheckoutModal() {
            if (cart.length === 0) return;

            // Mapping array cart ke format DTO CreateOrderItemRequest
            const payloadItems = cart.map(item => ({
                product_id: item.id,
                quantity: item.qty,
                notes: ""
            }));

            document.getElementById('itemsJsonInput').value = JSON.stringify(payloadItems);
            document.getElementById('checkoutModal').classList.remove('hidden');
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('hidden');
        }

        function toggleOrderFields() {
            const type = document.getElementById('orderTypeSelect').value;
            const tableField = document.getElementById('tableField');
            const addressField = document.getElementById('addressField');

            if (type === 'dine_in') {
                tableField.classList.remove('hidden');
                addressField.classList.add('hidden');
            } else if (type === 'delivery') {
                tableField.classList.add('hidden');
                addressField.classList.remove('hidden');
            } else {
                tableField.classList.add('hidden');
                addressField.classList.add('hidden');
            }
        }

        function togglePaymentInstructions() {
            const method = document.getElementById('userPaymentMethod').value;
            const qrisBox = document.getElementById('qrisInfoBox');
            const orderForm = document.getElementById('orderForm');

            if (method === 'qris') {
                qrisBox.classList.remove('hidden');
                // Auto scroll ke bawah di dalam form setelah info QRIS muncul
                setTimeout(() => {
                    orderForm.scrollTo({
                        top: orderForm.scrollHeight,
                        behavior: 'smooth'
                    });
                }, 100);
            } else {
                qrisBox.classList.add('hidden');
            }
        }
    </script>
@endsection
