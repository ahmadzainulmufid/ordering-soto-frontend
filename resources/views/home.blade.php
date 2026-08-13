@extends('layouts.app')

@section('title', 'Soto Lamongan Cak Mufid')

@section('content')
    <!-- Hero Section -->
    <section
        class="grid grid-cols-1 md:grid-cols-12 gap-gutter px-margin-mobile md:px-margin-desktop py-12 md:py-24 items-center">
        <div class="md:col-span-6 flex flex-col gap-6">

            <h1 class="font-display-lg text-display-lg text-primary leading-tight">
                Soto Lamongan Hangat, Gurih, dan Siap Dipesan
            </h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                Nikmati keaslian resep warisan keluarga dengan koya gurih melimpah. Tersedia untuk makan di tempat,
                ambil sendiri, atau pesan antar ke rumah Anda.
            </p>
            <div class="flex flex-wrap gap-4 mt-4">
                <button
                    class="bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-title-md text-title-md font-bold shadow-md hover:shadow-lg transition-all active:scale-95">
                    Pesan Sekarang
                </button>
                <button
                    class="border-2 border-secondary text-secondary px-8 py-4 rounded-xl font-title-md text-title-md font-bold hover:bg-secondary hover:text-white transition-all active:scale-95">
                    Lihat Menu
                </button>
            </div>
        </div>
        <div class="md:col-span-6 relative mt-12 md:mt-0">
            <div class="relative rounded-4xl overflow-hidden shadow-2xl aspect-4/3">
                <img class="w-full h-full object-cover"
                    data-alt="A cinematic, ultra-detailed food photography of a steaming bowl of Soto Lamongan. The soup is golden yellow, topped with shredded chicken, sliced boiled eggs, fresh scallions, and a generous dusting of white koya powder. The background is a warm, rustic wooden table with traditional Indonesian sambal and lime wedges. High-end lighting creates an appetizing and warm light-mode aesthetic with rich colors."
                    src="/images/soto-ayam_cak mufid.jpg" />
            </div>
            <!-- Floating Badges -->
            <div class="absolute -top-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce"
                style="animation-duration: 3s;">
                <div class="bg-primary-container p-2 rounded-lg">
                    <span class="material-symbols-outlined text-on-primary-container"
                        style="font-variation-settings: 'FILL' 1;">star</span>
                </div>
                <div>
                    <div class="font-label-sm text-label-sm text-on-surface-variant">Rating</div>
                    <div class="font-title-md text-title-md font-bold text-on-surface">4.9 / 5.0</div>
                </div>
            </div>
            <div class="absolute -bottom-6 -right-6 bg-secondary text-white px-6 py-4 rounded-2xl shadow-xl">
                <div class="font-title-md text-title-md font-bold">Best Seller</div>
                <div class="font-label-sm text-label-sm opacity-90">Favorit Pelanggan</div>
            </div>
        </div>
    </section>
    <!-- Trust Section -->
    <section class="bg-surface-container-low py-16">
        <div class="px-margin-mobile md:px-margin-desktop grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="flex flex-col items-center text-center gap-4 group">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors">
                    <span class="material-symbols-outlined text-4xl">eco</span>
                </div>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface">Fresh setiap hari</h3>
                    <p class="font-label-md text-label-md text-on-surface-variant">Bahan segar pilihan</p>
                </div>
            </div>
            <div class="flex flex-col items-center text-center gap-4 group">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors">
                    <span class="material-symbols-outlined text-4xl">restaurant_menu</span>
                </div>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface">Koya khas Lamongan</h3>
                    <p class="font-label-md text-label-md text-on-surface-variant">Gurih &amp; melimpah</p>
                </div>
            </div>
            <div class="flex flex-col items-center text-center gap-4 group">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors">
                    <span class="material-symbols-outlined text-4xl">verified</span>
                </div>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface">Bahan berkualitas</h3>
                    <p class="font-label-md text-label-md text-on-surface-variant">Tanpa pengawet</p>
                </div>
            </div>
            <div class="flex flex-col items-center text-center gap-4 group">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-primary shadow-sm group-hover:bg-primary-container group-hover:text-on-primary-container transition-colors">
                    <span class="material-symbols-outlined text-4xl">speed</span>
                </div>
                <div>
                    <h3 class="font-title-md text-title-md text-on-surface">Pesanan cepat</h3>
                    <p class="font-label-md text-label-md text-on-surface-variant">Sajian panas seketika</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Ordering Methods -->
    <section id="order" class="px-margin-mobile md:px-margin-desktop py-24">
        <div class="text-center mb-16">
            <h2 class="font-headline-lg text-headline-lg text-on-surface mb-4">Cara Pesan Fleksibel</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant">Pilih metode yang paling nyaman untuk Anda
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <!-- Method 1 -->
            <div class="bg-white p-8 rounded-3xl card-hover border border-outline-variant flex flex-col gap-6">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-secondary">
                    <span class="material-symbols-outlined text-3xl">restaurant</span>
                </div>
                <div>
                    <h3 class="font-headline-lg text-headline-lg text-on-surface mb-2">Makan di Tempat</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Nikmati suasana hangat warung
                        kami langsung dari panci panas.</p>
                </div>
                <div class="mt-auto">
                    <button
                        class="w-full bg-surface-variant text-on-surface-variant py-3 rounded-xl font-label-md text-label-md font-bold flex items-center justify-center gap-2">
                        Lihat Lokasi <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </div>
            <!-- Method 2 -->
            <div
                class="bg-white p-8 rounded-3xl card-hover border-2 border-primary-container flex flex-col gap-6 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 bg-primary-container text-on-primary-container px-4 py-1 font-label-sm text-label-sm rounded-bl-xl">
                    POPULER</div>
                <div class="w-14 h-14 bg-primary-container/20 flex items-center justify-center rounded-xl text-primary">
                    <span class="material-symbols-outlined text-3xl">shopping_bag</span>
                </div>
                <div>
                    <h3 class="font-headline-lg text-headline-lg text-on-surface mb-2">Ambil Sendiri</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Pesan online, ambil pesanan
                        Anda tanpa perlu mengantre.</p>
                </div>
                <div class="mt-auto">
                    <button
                        class="w-full bg-primary-container text-on-primary-container py-3 rounded-xl font-label-md text-label-md font-bold flex items-center justify-center gap-2">
                        Pesan Sekarang <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </div>
            <!-- Method 3 -->
            <div class="bg-white p-8 rounded-3xl card-hover border border-outline-variant flex flex-col gap-6">
                <div class="w-14 h-14 bg-surface-container flex items-center justify-center rounded-xl text-secondary">
                    <span class="material-symbols-outlined text-3xl">delivery_dining</span>
                </div>
                <div>
                    <h3 class="font-headline-lg text-headline-lg text-on-surface mb-2">Pesan Antar</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Kami antar soto hangat ke
                        depan pintu rumah Anda.</p>
                </div>
                <div class="mt-auto">
                    <button
                        class="w-full bg-surface-variant text-on-surface-variant py-3 rounded-xl font-label-md text-label-md font-bold flex items-center justify-center gap-2">
                        Pilih Alamat <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!-- lokasi -->
    <section id="lokasi" class="px-margin-mobile md:px-margin-desktop pb-24">
        <div
            class="bg-inverse-surface text-inverse-on-surface p-8 md:p-12 rounded-[3rem] relative overflow-hidden flex flex-col md:flex-row items-stretch justify-between gap-8">

            <!-- Informasi Lokasi & Kontak -->
            <div class="relative z-10 max-w-xl flex flex-col justify-center">
                <div
                    class="inline-flex items-center gap-2 bg-primary-container/20 text-primary-container px-4 py-2 rounded-full w-fit mb-4">
                    <span class="material-symbols-outlined text-sm">location_on</span>
                    <span class="font-label-md text-label-md">Kunjungi Warung Kami</span>
                </div>

                <h2 class="font-display-lg text-display-lg mb-4">Soto Lamongan Joko Tingkir</h2>
                <p class="font-body-lg text-body-lg opacity-80 mb-6">
                    Jl. Tole Iskandar, Simpangan, Kec. Cilodong, Kota Depok, Jawa Barat 16415
                </p>

                <!-- Detail Operational -->
                <div class="flex flex-col gap-3 mb-8 opacity-90">
                    <div class="flex items-center gap-3 font-body-md text-body-md">
                        <span class="material-symbols-outlined text-primary-container">schedule</span>
                        <span>Buka Setiap Hari: 08:00 - 15:00 WIB</span>
                    </div>
                    <div class="flex items-center gap-3 font-body-md text-body-md">
                        <span class="material-symbols-outlined text-primary-container">storefront</span>
                        <span>Melayani Makan di Tempat &amp; Bawa Pulang</span>
                    </div>
                </div>

                <!-- Tombol Buka Aplikasi Maps -->
                <div class="flex flex-wrap gap-4">
                    <a href="https://www.google.com/maps/place/Soto+Lamongan+Joko+Tingkir/@-6.4105508,106.8611976,19z"
                        target="_blank" rel="noopener noreferrer"
                        class="bg-primary-container text-on-primary-container px-8 py-4 rounded-xl font-bold whitespace-nowrap active:scale-95 transition-transform flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">directions</span>
                        Buka di Google Maps
                    </a>
                </div>
            </div>

            <!-- Google Maps Embed dengan Koordinat Presisi -->
            <div
                class="w-full md:w-1/2 min-h-75 md:min-h-87.5 relative z-10 rounded-2xl overflow-hidden shadow-lg border border-white/10">
                <iframe class="w-full h-full min-h-75"
                    src="https://maps.google.com/maps?q=-6.4105508,106.8611976&hl=id&z=18&output=embed" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            <!-- Background Glow -->
            <div
                class="w-full md:w-1/3 aspect-square rounded-full bg-primary-container/10 absolute -right-20 -bottom-20 blur-3xl pointer-events-none">
            </div>
        </div>
    </section>
@endsection
