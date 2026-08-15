@extends('layouts.admin')

@section('title', 'Kelola Katalog Menu - Soto Lamongan Cak Mufid')
@section('header_title', 'Kelola Katalog Menu')

@section('content')

    {{-- Alert Messages --}}
    @if (session('error'))
        <div
            class="bg-error-container text-on-error-container p-4 rounded-2xl border border-error/30 flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-error">error</span>
                <p class="text-sm font-bold">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="p-1 hover:bg-error/10 rounded-lg">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    @if (session('success'))
        <div id="alert-success"
            class="bg-secondary-container text-on-secondary-container p-4 rounded-2xl border border-secondary/30 flex items-center justify-between shadow-sm mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary text-2xl"
                    style="font-variation-settings: 'FILL' 1;">check_circle</span>
                <div>
                    <h4 class="font-label-md font-bold">Berhasil!</h4>
                    <p class="text-xs text-on-secondary-container/80">{{ session('success') }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('alert-success').remove()"
                class="p-1 hover:bg-secondary/10 rounded-lg">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    <!-- Header Section -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <h2 class="font-title-md text-2xl text-on-surface font-bold">Katalog Menu & Produk</h2>
            <p class="text-sm text-on-surface-variant">Atur variasi menu, penyesuaian harga, ketersediaan stok, dan foto
                makanan.</p>
        </div>

        <button onclick="openAddMenuModal()"
            class="px-5 py-3 bg-secondary text-white rounded-xl font-bold shadow-md hover:bg-secondary/90 transition-all flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            Tambah Menu Baru
        </button>
    </div>

    <!-- Filter & Search Toolbar -->
    <div
        class="tonal-layer-1 p-4 rounded-2xl border border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-4">

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

        <div
            class="flex items-center bg-surface-container px-4 py-2 rounded-xl w-full md:w-72 border border-outline-variant/30 focus-within:border-primary">
            <span class="material-symbols-outlined text-on-surface-variant mr-2 text-sm">search</span>
            <input type="text" id="searchMenuInput" onkeyup="searchMenuItems()" placeholder="Cari nama menu..."
                class="bg-transparent border-none focus:ring-0 text-xs w-full outline-none placeholder:text-on-surface-variant" />
        </div>
    </div>

    <!-- Grid Cards Produk Dinamis -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="menuGridContainer">

        @forelse ($products as $prod)
            <div class="menu-card tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30 flex flex-col justify-between hover:shadow-lg transition-all group {{ !($prod['is_available'] ?? true) ? 'opacity-80' : '' }}"
                data-category-id="{{ $prod['category_id'] }}" data-name="{{ strtolower($prod['name']) }}">

                <div class="relative">
                    <div
                        class="h-44 bg-surface-container-high w-full flex items-center justify-center relative overflow-hidden">
                        @if (!empty($prod['image_url']))
                            <img src="{{ $prod['image_url'] }}" alt="{{ $prod['name'] }}"
                                class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-5xl text-outline/40">restaurant</span>
                        @endif

                        <span
                            class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            {{ $prod['category_name'] ?? 'Menu' }}
                        </span>
                    </div>
                </div>

                <div class="p-5 space-y-3 grow flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <h3 class="font-bold text-on-surface text-base group-hover:text-primary transition-colors">
                                {{ $prod['name'] }}</h3>

                            @if ($prod['is_available'] ?? true)
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 shrink-0">Tersedia</span>
                            @else
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 shrink-0">Stok
                                    Habis</span>
                            @endif
                        </div>
                        <p class="text-xs text-on-surface-variant line-clamp-2">
                            {{ $prod['description'] ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div class="pt-3 border-t border-outline-variant/30 flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-on-surface-variant block">Harga Jual</span>
                            <span class="font-bold text-primary text-base">Rp
                                {{ number_format($prod['price'] ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center gap-1">
                            <button onclick="openEditMenuModal({{ json_encode($prod) }})"
                                class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                                title="Edit Menu">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>

                            <form action="{{ route('admin.menu.destroy', $prod['id']) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu {{ $prod['name'] }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                                    title="Hapus Menu">
                                    <span class="material-symbols-outlined text-lg">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full tonal-layer-1 p-12 text-center rounded-2xl border border-outline-variant/30">
                <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-2">restaurant_menu</span>
                <h4 class="font-bold text-on-surface">Belum ada menu produk.</h4>
                <p class="text-xs text-on-surface-variant">Klik tombol "Tambah Menu Baru" di atas untuk menambahkan sajian
                    menu pertama.</p>
            </div>
        @endforelse

    </div>

    <!-- MODAL 1: FORM TAMBAH MENU BARU -->
    <div id="addMenuModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div
            class="bg-surface-bright rounded-2xl p-6 max-w-lg w-full mx-4 shadow-2xl border border-outline-variant/30 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-title-md font-bold text-on-surface">Tambah Menu Baru</h3>
                <button onclick="closeAddMenuModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- ENCTYPE MULTIPART/FORM-DATA UNTUK UPLOAD Gambar -->
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Menu</label>
                    <input type="text" name="name" required placeholder="Contoh: Soto Ayam Campur"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Kategori Menu</label>
                        <select name="category_id" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                            <option value="" disabled selected>Pilih Kategori...</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-label-md text-xs mb-1">Harga Jual (Rp)</label>
                        <input type="number" name="price" required placeholder="25000"
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Stok Porsi</label>
                        <input type="number" name="stock" value="100" placeholder="100"
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                    <div>
                        <!-- FILE INPUT UPLOAD GAMBAR -->
                        <label class="block font-label-md text-xs mb-1">Foto Menu (PNG/JPG, Maks 2MB)</label>
                        <input type="file" name="image" accept="image/*"
                            class="w-full text-xs p-2 bg-surface-container rounded-xl outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary-container file:text-on-primary-container cursor-pointer" />
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Deskripsi Menu</label>
                    <textarea name="description" rows="2" placeholder="Sebutkan isian atau keunggulan menu..."
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeAddMenuModal()"
                        class="flex-1 py-3 border border-outline-variant rounded-xl font-bold text-sm">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-primary-container text-on-primary-container font-bold text-sm rounded-xl shadow-md">Simpan
                        Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: FORM EDIT MENU -->
    <div id="editMenuModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div
            class="bg-surface-bright rounded-2xl p-6 max-w-lg w-full mx-4 shadow-2xl border border-outline-variant/30 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-title-md font-bold text-on-surface">Edit Menu Produk</h3>
                <button onclick="closeEditMenuModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- ENCTYPE MULTIPART/FORM-DATA UNTUK UPLOAD Gambar -->
            <form id="editMenuForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Hidden Input untuk Menyimpan Gambar Lama -->
                <input type="hidden" id="edit_old_image_url" name="old_image_url" />

                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Menu</label>
                    <input type="text" id="edit_menu_name" name="name" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Kategori Menu</label>
                        <select id="edit_menu_category_id" name="category_id" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                            @foreach ($categories as $cat)
                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-label-md text-xs mb-1">Harga (Rp)</label>
                        <input type="number" id="edit_menu_price" name="price" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Stok Porsi</label>
                        <input type="number" id="edit_menu_stock" name="stock" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                    <div>
                        <label class="block font-label-md text-xs mb-1">Status Ketersediaan</label>
                        <select id="edit_menu_status" name="is_available" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                            <option value="true">Tersedia (Ready Stock)</option>
                            <option value="false">Stok Habis (Sold Out)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <!-- FILE INPUT UPLOAD GAMBAR EDIT -->
                    <label class="block font-label-md text-xs mb-1">Ganti Foto Menu (Biarkan kosong jika tidak
                        diganti)</label>
                    <input type="file" name="image" accept="image/*"
                        class="w-full text-xs p-2 bg-surface-container rounded-xl outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-primary-container file:text-on-primary-container cursor-pointer" />
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Deskripsi Menu</label>
                    <textarea id="edit_menu_description" name="description" rows="2"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditMenuModal()"
                        class="flex-1 py-3 border border-outline-variant rounded-xl font-bold text-sm">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-primary-container text-on-primary-container font-bold text-sm rounded-xl shadow-md">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JS Handlers -->
    <script>
        function openAddMenuModal() {
            document.getElementById('addMenuModal').classList.remove('hidden');
        }

        function closeAddMenuModal() {
            document.getElementById('addMenuModal').classList.add('hidden');
        }

        function openEditMenuModal(menu) {
            document.getElementById('edit_menu_name').value = menu.name || '';
            document.getElementById('edit_menu_category_id').value = menu.category_id || '';
            document.getElementById('edit_menu_price').value = menu.price || 0;
            document.getElementById('edit_menu_stock').value = menu.stock ?? 0;
            document.getElementById('edit_old_image_url').value = menu.image_url || '';
            document.getElementById('edit_menu_description').value = menu.description || '';
            document.getElementById('edit_menu_status').value = menu.is_available ? "true" : "false";

            // Set Form Action Dynamic
            document.getElementById('editMenuForm').action = `/admin/menu/${menu.id}`;

            document.getElementById('editMenuModal').classList.remove('hidden');
        }

        function closeEditMenuModal() {
            document.getElementById('editMenuModal').classList.add('hidden');
        }

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

        function searchMenuItems() {
            const input = document.getElementById('searchMenuInput').value.toLowerCase();
            const cards = document.querySelectorAll('.menu-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                if (name.includes(input)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection
