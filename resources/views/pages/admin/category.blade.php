@extends('layouts.admin')

@section('title', 'Kelola Kategori - Soto Lamongan Cak Mufid')
@section('header_title', 'Kelola Kategori Menu')

@section('content')

    {{-- Alert Error --}}
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

    {{-- Alert Success --}}
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

    <!-- Header & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="font-title-md text-2xl text-on-surface font-bold">Kategori Menu Makanan & Minuman</h2>
            <p class="text-sm text-on-surface-variant">Tambah, ubah nama, dan atur status pengelompokan menu di restoran.
            </p>
        </div>

        <button onclick="openAddCategoryModal()"
            class="px-5 py-3 bg-secondary text-white rounded-xl font-bold shadow-md hover:bg-secondary/90 transition-all flex items-center gap-2 w-fit">
            <span class="material-symbols-outlined text-sm">add_circle</span>
            Tambah Kategori Baru
        </button>
    </div>

    <!-- Table Container Card -->
    <div class="tonal-layer-1 rounded-2xl border border-outline-variant/30 overflow-hidden space-y-4 p-6">

        <!-- Filter & Search Toolbar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-4 border-b border-outline-variant/20">
            <div
                class="flex items-center bg-surface-container px-4 py-2 rounded-xl w-full sm:w-80 border border-outline-variant/30 focus-within:border-primary">
                <span class="material-symbols-outlined text-on-surface-variant mr-2 text-sm">search</span>
                <input type="text" id="searchInput" onkeyup="searchCategories()" placeholder="Cari nama kategori..."
                    class="bg-transparent border-none focus:ring-0 text-xs w-full outline-none placeholder:text-on-surface-variant" />
            </div>
            <span class="text-xs text-on-surface-variant font-bold">Total: <span
                    class="text-primary">{{ count($categories) }} Kategori</span></span>
        </div>

        <!-- Category Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="categoryTable">
                <thead>
                    <tr
                        class="bg-surface-container text-on-surface-variant font-label-md text-xs uppercase border-b border-outline-variant/30">
                        <th class="p-4 pl-6">ID</th>
                        <th class="p-4">Nama Kategori</th>
                        <th class="p-4">Slug URL</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20 font-body-md text-sm text-on-surface">

                    @forelse ($categories as $cat)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="p-4 pl-6 font-bold text-primary">
                                #CAT-{{ str_pad($cat['id'] ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="p-4 font-bold">{{ $cat['name'] ?? '-' }}</td>
                            <td class="p-4 text-on-surface-variant font-mono text-xs">{{ $cat['slug'] ?? '-' }}</td>
                            <td class="p-4">
                                @if ($cat['is_active'] ?? true)
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Aktif</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Tombol Edit -->
                                    <button onclick="openEditCategoryModal({{ json_encode($cat) }})"
                                        class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>

                                    <!-- Form Delete -->
                                    <form action="{{ route('admin.category.destroy', $cat['id']) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $cat['name'] }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                                            title="Hapus">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2 block">category</span>
                                Belum ada data kategori. Klik <strong class="text-secondary">Tambah Kategori Baru</strong>.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: CREATE CATEGORY -->
    <div id="addCategoryModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div class="bg-surface-bright rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-outline-variant/30">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-lg font-bold text-on-surface">Tambah Kategori Baru</h3>
                <button onclick="closeAddCategoryModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('admin.category.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Kategori</label>
                    <input type="text" name="name" required placeholder="Contoh: Ekstra / Topping"
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeAddCategoryModal()"
                        class="flex-1 py-3 border border-outline-variant rounded-xl font-bold text-sm">Batal</button>
                    <button type="submit"
                        class="flex-1 py-3 bg-primary-container text-on-primary-container font-bold text-sm rounded-xl shadow-md">Simpan
                        Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: UPDATE CATEGORY -->
    <div id="editCategoryModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
        <div class="bg-surface-bright rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-outline-variant/30">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-md text-lg font-bold text-on-surface">Edit Kategori</h3>
                <button onclick="closeEditCategoryModal()" class="p-1 hover:bg-surface-container rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="editCategoryForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-label-md text-xs mb-1">Nama Kategori</label>
                    <input type="text" id="edit_category_name" name="name" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                </div>

                <div>
                    <label class="block font-label-md text-xs mb-1">Status Kategori</label>
                    <select id="edit_category_is_active" name="is_active" required
                        class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                        <option value="true">Aktif (Tampil di Menu)</option>
                        <option value="false">Non-Aktif (Disembunyikan)</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeEditCategoryModal()"
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
        function openAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.remove('hidden');
        }

        function closeAddCategoryModal() {
            document.getElementById('addCategoryModal').classList.add('hidden');
        }

        function openEditCategoryModal(category) {
            document.getElementById('edit_category_name').value = category.name || '';
            document.getElementById('edit_category_is_active').value = category.is_active ? "true" : "false";

            // Set Form Dynamic Action Endpoint
            document.getElementById('editCategoryForm').action = `/admin/category/${category.id}`;

            document.getElementById('editCategoryModal').classList.remove('hidden');
        }

        function closeEditCategoryModal() {
            document.getElementById('editCategoryModal').classList.add('hidden');
        }

        function searchCategories() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#categoryTable tbody tr');

            rows.forEach(row => {
                const name = row.children[1].textContent.toLowerCase();
                if (name.includes(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
