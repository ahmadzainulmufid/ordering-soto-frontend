@extends('layouts.admin')

@section('title', 'Pengaturan - Soto Lamongan Cak Mufid')
@section('header_title', 'Pengaturan Sistem')

@section('content')

    {{-- Alert Notifikasi Error --}}
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

    {{-- Alert Notifikasi Success --}}
    @if (session('success'))
        <div
            class="bg-secondary-container text-on-secondary-container p-4 rounded-2xl border border-secondary/30 flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-secondary">check_circle</span>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="p-1 hover:bg-secondary/10 rounded-lg">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    @endif

    <div class="space-y-6">

        <!-- Top Sub-Menu Navigation Tabs -->
        <div class="flex items-center gap-3 border-b border-outline-variant/40 pb-4">
            <a href="{{ route('admin.setting', ['tab' => 'staff']) }}"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-label-md font-bold transition-all {{ request()->get('tab', 'staff') == 'staff' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined text-sm">badge</span>
                Manajemen Staf
            </a>

            <a href="{{ route('admin.setting', ['tab' => 'profile']) }}"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-label-md font-bold transition-all {{ request()->get('tab') == 'profile' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high' }}">
                <span class="material-symbols-outlined text-sm">storefront</span>
                Profil Restoran
            </a>
        </div>

        @if (request()->get('tab', 'staff') == 'staff')
            <!-- TAB CONTENT 1: MANAJEMEN STAF -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="font-title-md text-title-md text-on-surface font-bold">Kelola Pengguna & Akses Staf</h2>
                    <p class="font-body-md text-sm text-on-surface-variant">Tambah, edit, dan atur hak akses akun Kasir,
                        Dapur, maupun Admin.</p>
                </div>

                <button onclick="openAddUserModal()"
                    class="px-5 py-2.5 bg-secondary text-white rounded-xl font-label-md text-label-md font-bold shadow-md hover:bg-secondary/90 transition-all flex items-center gap-2 w-fit">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Tambah Staf Baru
                </button>
            </div>

            <!-- Tabel Daftar Staf -->
            <div class="tonal-layer-1 rounded-2xl border border-outline-variant/30 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-surface-container text-on-surface-variant font-label-md text-label-md border-b border-outline-variant/30">
                                <th class="p-4 pl-6">ID</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4">Email</th>
                                <th class="p-4">No. HP</th>
                                <th class="p-4">Peran (Role)</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20 font-body-md text-body-md text-on-surface">

                            @forelse ($users as $user)
                                <tr class="hover:bg-surface-container-low transition-colors">
                                    <td class="p-4 pl-6 font-bold text-primary">
                                        #USR-{{ str_pad($user['id'] ?? $loop->iteration, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="p-4 font-bold">{{ $user['full_name'] ?? '-' }}</td>
                                    <td class="p-4">{{ $user['email'] ?? '-' }}</td>
                                    <td class="p-4">{{ $user['phone'] ?? '-' }}</td>
                                    <td class="p-4">
                                        @php $role = strtolower($user['role'] ?? ''); @endphp
                                        @if ($role === 'owner')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 uppercase">Owner</span>
                                        @elseif($role === 'admin')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 uppercase">Admin</span>
                                        @elseif($role === 'cashier')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase">Kasir</span>
                                        @elseif($role === 'kitchen')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 uppercase">Dapur</span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 uppercase">{{ $role }}</span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        @if ($user['is_active'] ?? true)
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span
                                                class="px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        @if (($user['role'] ?? '') === 'owner')
                                            <span class="text-xs text-on-surface-variant italic">Pemilik Utama</span>
                                        @else
                                            <div class="flex items-center justify-center gap-1">
                                                <!-- Tombol Edit -->
                                                <button onclick="openEditUserModal({{ json_encode($user) }})"
                                                    class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors"
                                                    title="Edit">
                                                    <span class="material-symbols-outlined text-sm">edit</span>
                                                </button>

                                                <!-- Form & Tombol Hapus -->
                                                <form action="{{ route('admin.users.destroy', $user['id']) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus staf {{ $user['full_name'] }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 hover:bg-surface-container rounded-lg text-tertiary transition-colors"
                                                        title="Hapus">
                                                        <span class="material-symbols-outlined text-sm">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-4xl mb-2 block">group_off</span>
                                        Belum ada data staf. Klik <strong class="text-secondary">Tambah Staf Baru</strong>
                                        untuk menambahkan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Form Tambah Staf -->
            <div id="editUserModal"
                class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
                <div
                    class="bg-surface-bright rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl border border-outline-variant/30">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-title-md text-title-md font-bold text-on-surface">Edit Data Staf</h3>
                        <button onclick="closeEditUserModal()" class="p-1 hover:bg-surface-container rounded-lg">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form id="editUserForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block font-label-md text-xs mb-1">Nama Lengkap</label>
                            <input type="text" id="edit_full_name" name="full_name" required
                                class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                        </div>

                        <div>
                            <label class="block font-label-md text-xs mb-1">Nomor HP</label>
                            <input type="text" id="edit_phone" name="phone"
                                class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                        </div>

                        <div>
                            <label class="block font-label-md text-xs mb-1">Peran Akses (Role)</label>
                            <select id="edit_role" name="role" required
                                class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">
                                <option value="cashier">Kasir (Cashier)</option>
                                <option value="kitchen">Dapur (Kitchen)</option>
                                <option value="admin">Admin Operasional</option>
                            </select>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="closeEditUserModal()"
                                class="flex-1 py-3 border border-outline-variant rounded-xl font-bold">Batal</button>
                            <button type="submit"
                                class="flex-1 py-3 bg-primary-container text-on-primary-container font-bold rounded-xl shadow-md">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- TAB CONTENT 2: PROFIL RESTORAN -->
            <div class="tonal-layer-1 p-8 rounded-2xl border border-outline-variant/30 max-w-2xl space-y-6">
                <div>
                    <h2 class="font-title-md text-title-md text-on-surface font-bold">Informasi Gerai Restoran</h2>
                    <p class="text-sm text-on-surface-variant">Atur informasi utama gerai yang ditampilkan pada sistem.</p>
                </div>

                <form action="{{ route('admin.setting.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-label-md text-xs mb-1">Nama Restoran / Gerai</label>
                        <input type="text" name="restaurant_name" value="{{ $profile['restaurant_name'] ?? '' }}"
                            required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                    </div>

                    <div>
                        <label class="block font-label-md text-xs mb-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" required
                            class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container">{{ $profile['address'] ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-label-md text-xs mb-1">No. Telepon / WA</label>
                            <input type="text" name="phone" value="{{ $profile['phone'] ?? '' }}" required
                                class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                        </div>
                        <div>
                            <label class="block font-label-md text-xs mb-1">Jam Operasional</label>
                            <input type="text" name="opening_hours" value="{{ $profile['opening_hours'] ?? '' }}"
                                required
                                class="w-full p-3 bg-surface-container rounded-xl text-sm outline-none focus:ring-2 focus:ring-primary-container" />
                        </div>
                    </div>

                    <button type="submit"
                        class="py-3 px-6 bg-secondary text-white font-bold rounded-xl shadow-md hover:bg-secondary/90 transition-all">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>
        @endif

    </div>

    <script>
        function openAddUserModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }

        // Fungsi Pembuka Modal Edit
        function openEditUserModal(user) {
            document.getElementById('edit_full_name').value = user.full_name || '';
            document.getElementById('edit_phone').value = user.phone || '';
            document.getElementById('edit_role').value = user.role || 'cashier';

            // Atur action form ke endpoint update dengan ID spesifik
            document.getElementById('editUserForm').action = `/admin/users/${user.id}`;

            document.getElementById('editUserModal').classList.remove('hidden');
        }

        function closeEditUserModal() {
            document.getElementById('editUserModal').classList.add('hidden');
        }
    </script>
@endsection
