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

    <!-- Main Content Area (Ganti ml-70 jadi ml-72) -->
    <main class="ml-72 min-h-screen flex flex-col min-w-0">

        <!-- TopAppBar Sticky -->
        <header
            class="top-0 sticky bg-surface-bright border-b border-outline-variant flex justify-between items-center px-8 py-4 w-full z-40">
            <div class="flex items-center gap-4">
                <div class="flex items-center text-on-surface-variant font-label-md text-label-md">
                    <span class="capitalize">{{ session('user.role', 'Owner') }} Panel</span>
                    <span class="material-symbols-outlined text-[16px] mx-2">chevron_right</span>
                    <span class="text-primary font-bold">@yield('header_title', 'Dashboard')</span>
                </div>
                <div
                    class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full w-[320px] ml-8 border border-outline-variant focus-within:border-primary transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                    <input
                        class="bg-transparent border-none focus:ring-0 text-sm w-full placeholder:text-on-surface-variant"
                        placeholder="Cari pesanan atau menu..." type="text" />
                </div>
            </div>

            <div class="flex items-center gap-6">
                <button
                    class="relative text-on-surface-variant hover:bg-surface-container-low p-2 rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-tertiary rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 pl-6 border-l border-outline-variant">
                    <div class="text-right">
                        <p class="font-label-md text-label-md text-on-surface font-bold">
                            {{ session('user.full_name', 'Cak Mufid') }}
                        </p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant capitalize">
                            {{ session('user.role', 'Owner') }}
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container font-bold flex items-center justify-center border-2 border-primary-container text-lg shadow-sm">
                        {{ strtoupper(substr(session('user.full_name', 'C'), 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="p-8 space-y-8 grow">
            @yield('content')
        </div>

    </main>

    <!-- Floating Quick Action -->
    <button
        class="fixed bottom-8 right-8 w-16 h-16 bg-primary-container text-on-primary-container rounded-2xl shadow-xl hover:scale-110 active:scale-95 transition-all flex items-center justify-center z-40">
        <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">add</span>
    </button>

    {{-- Asset Script --}}
    @include('includes.script')

    {{-- Modal Logout Include --}}
    @include('includes.logout-modal')

</body>

</html>
