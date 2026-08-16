<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'Kitchen Panel - Soto Lamongan Cak Mufid')</title>

    {{-- Asset Style & Tailwind --}}
    @include('includes.style')

    <style>
        .tonal-layer-1 {
            background: #ffffff;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen">

    <!-- Sidebar Kitchen Hijau -->
    <aside class="left-0 top-0 h-screen w-72 fixed bg-secondary text-on-secondary shadow-md flex flex-col py-6 z-50">

        <!-- Header / Brand Logo -->
        <div class="px-6 mb-8 flex items-center gap-3">
            <div
                class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary-container shadow-sm shrink-0">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">soup_kitchen</span>
            </div>
            <div class="min-w-0">
                <h1 class="font-title-md text-title-md text-primary-container font-bold truncate">
                    {{ session('user.full_name', 'Staf Dapur') }}
                </h1>
                <p class="font-label-sm text-label-sm text-white/80 capitalize">
                    Kitchen Panel
                </p>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="grow space-y-1 overflow-y-auto custom-scrollbar px-2">
            <a href="{{ route('kitchen.orders.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 mx-2 transition-all group {{ request()->routeIs('kitchen.orders.*') ? 'bg-primary-container text-on-primary-container font-bold shadow-md translate-x-1' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                <span class="material-symbols-outlined">skillet</span>
                <span class="font-label-md text-label-md">Kelola Pesanan Dapur</span>
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

    <!-- Main Content Area -->
    <main class="ml-72 min-h-screen flex flex-col min-w-0">

        <!-- TopAppBar -->
        <header
            class="top-0 sticky bg-surface-bright border-b border-outline-variant flex justify-between items-center px-8 py-4 w-full z-40">
            <div class="flex items-center gap-4">
                <div class="flex items-center text-on-surface-variant font-label-md text-label-md">
                    <span>Kitchen Panel</span>
                    <span class="material-symbols-outlined text-[16px] mx-2">chevron_right</span>
                    <span class="text-primary font-bold">@yield('header_title', 'Antrean Pesanan')</span>
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
                                <h4 class="font-bold text-sm text-on-surface">Riwayat Aktivitas Dapur</h4>
                            </div>
                            <span
                                class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container">Terbaru</span>
                        </div>

                        <!-- Activity Log List Container -->
                        <div class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-outline-variant/20">

                            <!-- Order Masuk -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-red-100 text-red-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">soup_kitchen</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Pesanan baru masuk
                                        <span class="font-bold text-primary">"#ORD-3013"</span> (Takeaway)
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">Baru saja •
                                        System</span>
                                </div>
                            </div>

                            <!-- Pesanan Dimasak -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-amber-100 text-amber-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">skillet</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Mulai memasak
                                        <span class="font-bold text-amber-800">"#ORD-3012"</span> (Meja 02)
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">8 menit yang lalu •
                                        Staf Dapur</span>
                                </div>
                            </div>

                            <!-- Pesanan Selesai -->
                            <div class="p-3.5 hover:bg-surface-container-low transition-colors flex gap-3 items-start">
                                <div class="p-2 rounded-xl bg-green-100 text-green-700 shrink-0 mt-0.5">
                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                </div>
                                <div class="grow min-w-0">
                                    <p class="text-xs text-on-surface font-semibold leading-tight">Pesanan disajikan
                                        <span class="font-bold text-green-800">"#ORD-3011"</span> (Meja 08)
                                    </p>
                                    <span class="text-[10px] text-on-surface-variant mt-1 block">15 menit yang lalu •
                                        Staf Dapur</span>
                                </div>
                            </div>

                        </div>

                        <!-- Dropdown Footer -->
                        <div class="p-2.5 bg-surface-container-lowest text-center border-t border-outline-variant/30">
                            <span class="text-[11px] text-on-surface-variant font-medium">Log antrean dicatat
                                otomatis</span>
                        </div>

                    </div>
                </div>

                <!-- User Profile Info -->
                <div class="flex items-center gap-3 pl-6 border-l border-outline-variant">
                    <div class="text-right">
                        <p class="font-label-md text-label-md text-on-surface font-bold">
                            {{ session('user.full_name', 'Staf Dapur') }}
                        </p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant capitalize">
                            Kitchen Team
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container font-bold flex items-center justify-center border-2 border-primary-container text-lg shadow-sm">
                        {{ strtoupper(substr(session('user.full_name', 'K'), 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Canvas -->
        <div class="p-8 space-y-8 grow">
            @yield('content')
        </div>

    </main>

    {{-- Asset Script & Modal Logout --}}
    @include('includes.script')
    @include('includes.logout-modal')

</body>

</html>
