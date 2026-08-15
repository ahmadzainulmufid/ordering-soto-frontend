<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Owner Dashboard - Soto Lamongan Cak Mufid')</title>

    {{-- Asset Style & Tailwind --}}
    @include('includes.style')

    <style>
        .tonal-layer-1 {
            background: #ffffff;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
        }

        .chart-gradient {
            background: linear-gradient(180deg, rgba(120, 89, 0, 0.1) 0%, rgba(120, 89, 0, 0) 100%);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen">

    <!-- Sidebar Owner Hijau (Ganti w-70 jadi w-72) -->
    <aside class="left-0 top-0 h-screen w-72 fixed bg-secondary text-on-secondary shadow-md flex flex-col py-6 z-50">

        <!-- Header / Brand Logo -->
        <div class="px-6 mb-8 flex items-center gap-3">
            <div
                class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary-container shadow-sm shrink-0">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">restaurant</span>
            </div>
            <div class="min-w-0">
                <h1 class="font-title-md text-title-md text-primary-container font-bold truncate">
                    {{ session('user.full_name', 'Cak Mufid') }}
                </h1>
                <p class="font-label-sm text-label-sm text-white/80 capitalize">
                    {{ session('user.role', 'Owner') }} Panel
                </p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="grow space-y-1 overflow-y-auto custom-scrollbar px-2">
            <a href="{{ route('owner.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 mx-2 transition-all group {{ request()->is('owner/dashboard*') ? 'bg-primary-container text-on-primary-container font-bold shadow-md translate-x-1' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 text-white/80 px-4 py-3 mx-2 hover:bg-white/10 hover:text-white rounded-lg transition-colors group">
                <span class="material-symbols-outlined">receipt_long</span>
                <span class="font-label-md text-label-md">Pesanan Masuk</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 text-white/80 px-4 py-3 mx-2 hover:bg-white/10 hover:text-white rounded-lg transition-colors group">
                <span class="material-symbols-outlined">restaurant_menu</span>
                <span class="font-label-md text-label-md">Kelola Menu</span>
            </a>

            <a href="#"
                class="flex items-center gap-3 text-white/80 px-4 py-3 mx-2 hover:bg-white/10 hover:text-white rounded-lg transition-colors group">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-label-md text-label-md">Laporan</span>
            </a>

            <a href="{{ route('owner.setting') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 mx-2 transition-all group {{ request()->is('owner/setting*') ? 'bg-primary-container text-on-primary-container font-bold shadow-md translate-x-1' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-label-md text-label-md">Pengaturan</span>
            </a>
        </nav>

        <!-- Fixed Bottom Logout Button -->
        <div class="px-4 pt-4 mt-auto border-t border-white/15">
            <button type="button" onclick="openLogoutModal()"
                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-tertiary/20 text-tertiary-container hover:bg-tertiary hover:text-white font-label-md font-bold transition-all shadow-sm">
                <span class="material-symbols-outlined text-sm">logout</span>
                Keluar (Logout)
            </button>
        </div>
    </aside>

    <!-- Main Content Area  -->
    <main class="ml-72 min-h-screen flex flex-col min-w-0">

        <!-- TopAppBar -->
        <header
            class="top-0 sticky bg-surface-bright border-b border-outline-variant flex justify-between items-center px-8 py-4 w-full z-40">
            <div class="flex items-center gap-4">
                <div class="flex items-center text-on-surface-variant font-label-md text-label-md">
                    <span>Admin Panel</span>
                    <span class="material-symbols-outlined text-[16px] mx-2">chevron_right</span>
                    <span class="text-primary font-bold">@yield('header_title', 'Kelola Menu')</span>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- Notification Bell Dropdown Wrapper -->
                <div class="relative">
                    <button id="notifBellBtn" onclick="toggleNotificationDropdown()"
                        class="relative text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors flex items-center justify-center focus:outline-none">
                        <span class="material-symbols-outlined text-2xl">notifications</span>

                        <!-- Red Badge Dot -->
                        <span id="notifBadge"
                            class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-tertiary rounded-full ring-2 ring-surface-bright animate-pulse"></span>
                    </button>

                    <!-- Dropdown Menu Box -->
                    <div id="notifDropdown"
                        class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-surface-bright rounded-2xl shadow-xl border border-outline-variant/30 z-50 overflow-hidden transform transition-all duration-200 origin-top-right">

                        <!-- Dropdown Header -->
                        <div
                            class="p-4 border-b border-outline-variant/30 flex items-center justify-between bg-surface-container-lowest">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-xl">history</span>
                                <h4 class="font-bold text-sm text-on-surface">Riwayat Aktivitas</h4>
                            </div>
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container">Terbaru</span>
                        </div>

                        <!-- Activity Log List Container -->
                        <div class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-outline-variant/20">

                            <!-- Tambah Menu -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-green-100 text-green-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">add_circle</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Menambahkan menu baru
                                        <span class="font-bold text-primary">"Soto Spesial Ceker"</span>
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">5 menit yang lalu •
                                        Admin</span>
                                </div>
                            </div>

                            <!-- Update Stok -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-amber-100 text-amber-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">inventory</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Mengubah status stok
                                        <span class="font-bold text-amber-800">"Es Jeruk Peras"</span> menjadi Habis
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">28 menit yang lalu •
                                        Admin</span>
                                </div>
                            </div>

                            <!-- Tambah Meja -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-blue-100 text-blue-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">table_restaurant</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Menambahkan meja baru
                                        <span class="font-bold text-blue-800">"Meja 09"</span> & QR Token
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">1 jam yang lalu •
                                        Admin</span>
                                </div>
                            </div>

                            <!-- Edit Kategori -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-purple-100 text-purple-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">edit</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Memperbarui nama
                                        kategori <span class="font-bold text-purple-800">"Minuman Segar"</span></p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">2 jam yang lalu •
                                        Admin</span>
                                </div>
                            </div>

                        </div>

                        <!-- Dropdown Footer -->
                        <div class="p-2.5 bg-surface-container-lowest text-center border-t border-outline-variant/30">
                            <span class="text-[11px] text-on-surface-variant font-medium">Log aktivitas dicatat otomatis
                                oleh sistem</span>
                        </div>

                    </div>
                </div>

                <!-- User Profile Info -->
                <div class="flex items-center gap-3 pl-6 border-l border-outline-variant">
                    <div class="text-right">
                        <p class="font-label-md text-label-md text-on-surface font-bold">
                            {{ session('user.full_name', 'Admin Operasional') }}
                        </p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant capitalize">
                            Admin
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container font-bold flex items-center justify-center border-2 border-primary-container text-lg shadow-sm">
                        {{ strtoupper(substr(session('user.full_name', 'A'), 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="p-8 space-y-8 grow">
            @yield('content')
        </div>

    </main>

    {{-- Asset Script --}}
    @include('includes.script')

    {{-- Modal Logout Include --}}
    @include('includes.logout-modal')

</body>

</html>
