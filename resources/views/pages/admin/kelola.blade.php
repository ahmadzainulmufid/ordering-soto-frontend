@extends('layouts.admin')

@section('title', 'Kelola Katalog Menu - Soto Lamongan Cak Mufid')
@section('header_title', 'Kelola Katalog Menu')

@section('content')

    <!-- Flash Message Success -->
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

    <!-- Header Section & Filter Control Bar -->
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
        <!-- Filter Kategori Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto custom-scrollbar pb-1 md:pb-0">
            <button
                class="px-4 py-2 rounded-xl text-xs font-bold bg-primary-container text-on-primary-container shadow-sm whitespace-nowrap">
                Semua (12)
            </button>
            <button
                class="px-4 py-2 rounded-xl text-xs font-bold bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors whitespace-nowrap">
                Makanan Utama (5)
            </button>
            <button
                class="px-4 py-2 rounded-xl text-xs font-bold bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors whitespace-nowrap">
                Minuman (4)
            </button>
            <button
                class="px-4 py-2 rounded-xl text-xs font-bold bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors whitespace-nowrap">
                Pendamping (3)
            </button>
        </div>

        <!-- Search Input Bar -->
        <div
            class="flex items-center bg-surface-container px-4 py-2 rounded-xl w-full md:w-72 border border-outline-variant/30 focus-within:border-primary">
            <span class="material-symbols-outlined text-on-surface-variant mr-2 text-sm">search</span>
            <input type="text" placeholder="Cari nama menu..."
                class="bg-transparent border-none focus:ring-0 text-xs w-full outline-none placeholder:text-on-surface-variant" />
        </div>
    </div>

    <!-- Grid Cards Katalog Menu -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        <!-- Card Menu 1 (Tersedia) -->
        <div
            class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30 flex flex-col justify-between hover:shadow-lg transition-all group">
            <div class="relative">
                <!-- Image Holder / Preview -->
                <div
                    class="h-44 bg-surface-container-high w-full flex items-center justify-center relative overflow-hidden">
                    <span class="material-symbols-outlined text-5xl text-outline/40">ramen_dining</span>
                    <!-- Badge Kategori -->
                    <span
                        class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                        Makanan Utama
                    </span>
                </div>
            </div>

            <div class="p-5 space-y-3 grow flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-1">
                        <h3 class="font-bold text-on-surface text-base group-hover:text-primary transition-colors">Soto Ayam
                            Campur</h3>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 shrink-0">Tersedia</span>
                    </div>
                    <p class="text-xs text-on-surface-variant line-clamp-2">Soto ayam kuah kuning gurih koya dengan nasi
                        dicampur segar.</p>
                </div>

                <div class="pt-3 border-t border-outline-variant/30 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-on-surface-variant block">Harga Jual</span>
                        <span class="font-bold text-primary text-base">Rp 25.000</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <button
                            onclick="openEditMenuModal({id: 1, name: 'Soto Ayam Campur', category: 'makanan', price: 25000, is_available: true})"
                            class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                            title="Edit Menu">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button onclick="confirmDeleteMenu('Soto Ayam Campur')"
                            class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                            title="Hapus Menu">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Menu 2 (Tersedia) -->
        <div
            class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30 flex flex-col justify-between hover:shadow-lg transition-all group">
            <div class="relative">
                <div
                    class="h-44 bg-surface-container-high w-full flex items-center justify-center relative overflow-hidden">
                    <span class="material-symbols-outlined text-5xl text-outline/40">soup_kitchen</span>
                    <span
                        class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                        Makanan Utama
                    </span>
                </div>
            </div>

            <div class="p-5 space-y-3 grow flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-1">
                        <h3 class="font-bold text-on-surface text-base group-hover:text-primary transition-colors">Soto Ayam
                            Pisah</h3>
                        <span
                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-800 shrink-0">Tersedia</span>
                    </div>
                    <p class="text-xs text-on-surface-variant line-clamp-2">Nasi dan soto dipisah porsi jumbo dengan koya
                        melimpah.</p>
                </div>

                <div class="pt-3 border-t border-outline-variant/30 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-on-surface-variant block">Harga Jual</span>
                        <span class="font-bold text-primary text-base">Rp 28.000</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <button
                            onclick="openEditMenuModal({id: 2, name: 'Soto Ayam Pisah', category: 'makanan', price: 28000, is_available: true})"
                            class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                            title="Edit Menu">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button onclick="confirmDeleteMenu('Soto Ayam Pisah')"
                            class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                            title="Hapus Menu">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Menu 3 (Stok Habis) -->
        <div
            class="tonal-layer-1 rounded-2xl overflow-hidden border border-outline-variant/30 flex flex-col justify-between hover:shadow-lg transition-all group opacity-85">
            <div class="relative">
                <div
                    class="h-44 bg-surface-container-high w-full flex items-center justify-center relative overflow-hidden grayscale">
                    <span class="material-symbols-outlined text-5xl text-outline/40">local_drink</span>
                    <span
                        class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                        Minuman
                    </span>
                </div>
            </div>

            <div class="p-5 space-y-3 grow flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start gap-2 mb-1">
                        <h3 class="font-bold text-on-surface text-base group-hover:text-primary transition-colors">Es Jeruk
                            Peras</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-800 shrink-0">Stok
                            Habis</span>
                    </div>
                    <p class="text-xs text-on-surface-variant line-clamp-2">Es jeruk peras alami segar buah manis.</p>
                </div>

                <div class="pt-3 border-t border-outline-variant/30 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-on-surface-variant block">Harga Jual</span>
                        <span class="font-bold text-primary text-base">Rp 8.000</span>
                    </div>

                    <div class="flex items-center gap-1">
                        <button
                            onclick="openEditMenuModal({id: 3, name: 'Es Jeruk Peras', category: 'minuman', price: 8000, is_available: false})"
                            class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                            title="Edit Menu">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button onclick="confirmDeleteMenu('Es Jeruk Peras')"
                            class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                            title="Hapus Menu">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- FORM TAMBAH MENU BARU -->
    <div id="addMenuModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div class="bg-surface-bright rounded-2xl p-6 max-w-lg w-full mx-4 shadow-2xl border border-outline-variant/30">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-title-md font-bold text-on-surface">Tambah Menu Baru</h3>
                <button onclick="closeAddMenuModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Menu Makanan / Minuman</label>
                    <input type="text" name="name" required placeholder="Contoh: Soto Ayam Ceker"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Kategori</label>
                        <select name="category" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                            <option value="makanan">Makanan Utama</option>
                            <option value="minuman">Minuman</option>
                            <option value="pendamping">Pendamping / Ekstra</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-label-md text-xs mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="25000"
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Deskripsi Singkat</label>
                    <textarea name="description" rows="2" placeholder="Sebutkan isian atau keunggulan menu..."
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container"></textarea>
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Status Ketersediaan</label>
                    <div class="flex gap-4 pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold">
                            <input type="radio" name="is_available" value="1" checked class="accent-primary" />
                            Tersedia
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-error">
                            <input type="radio" name="is_available" value="0" class="accent-error" /> Stok Habis
                        </label>
                    </div>
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

    <!-- FORM EDIT MENU -->
    <div id="editMenuModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div class="bg-surface-bright rounded-2xl p-6 max-w-lg w-full mx-4 shadow-2xl border border-outline-variant/30">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-title-md font-bold text-on-surface">Edit Menu Produk</h3>
                <button onclick="closeEditMenuModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editMenuForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Menu</label>
                    <input type="text" id="edit_menu_name" name="name" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-label-md text-xs mb-1">Kategori</label>
                        <select id="edit_menu_category" name="category" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                            <option value="makanan">Makanan Utama</option>
                            <option value="minuman">Minuman</option>
                            <option value="pendamping">Pendamping / Ekstra</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-label-md text-xs mb-1">Harga (Rp)</label>
                        <input type="number" id="edit_menu_price" name="price" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Status Ketersediaan Stok</label>
                    <select id="edit_menu_status" name="is_available" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                        <option value="1">Tersedia (Ready Stock)</option>
                        <option value="0">Stok Habis (Sold Out)</option>
                    </select>
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

    <!-- JavaScript Handlers Modal -->
    <script>
        function openAddMenuModal() {
            document.getElementById('addMenuModal').classList.remove('hidden');
        }

        function closeAddMenuModal() {
            document.getElementById('addMenuModal').classList.add('hidden');
        }

        function openEditMenuModal(menu) {
            document.getElementById('edit_menu_name').value = menu.name;
            document.getElementById('edit_menu_category').value = menu.category;
            document.getElementById('edit_menu_price').value = menu.price;
            document.getElementById('edit_menu_status').value = menu.is_available ? "1" : "0";

            document.getElementById('editMenuModal').classList.remove('hidden');
        }

        function closeEditMenuModal() {
            document.getElementById('editMenuModal').classList.add('hidden');
        }

        function confirmDeleteMenu(menuName) {
            if (confirm(`Apakah Anda yakin ingin menghapus menu "${menuName}" dari katalog?`)) {
                alert(`Menu ${menuName} berhasil dihapus.`);
            }
        }
    </script>
@endsection
