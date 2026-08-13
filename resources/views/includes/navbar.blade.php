<!-- Desktop TopNavBar -->
<nav class="bg-secondary sticky top-0 z-50 shadow-md hidden md:block">
    <div class="flex justify-between items-center w-full px-margin-desktop py-4">
        <div class="font-display-lg text-display-lg font-bold text-primary-container">
            Soto Lamongan
        </div>

        <!-- Navigasi Links -->
        <div class="flex items-center gap-8">
            <a data-nav="hero" href="{{ url('/') }}"
                class="nav-link font-label-md text-label-md text-primary-container border-b-2 border-primary-container pb-1 transition-all">
                Beranda
            </a>
            <a data-nav="menu" href="{{ url('/#menu') }}"
                class="nav-link font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Menu
            </a>
            <a data-nav="order" href="{{ url('/#order') }}"
                class="nav-link font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Cara Pesan
            </a>
            <a data-nav="lokasi" href="{{ url('/#lokasi') }}"
                class="nav-link font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Lokasi
            </a>
            <a data-nav="lacak" href="#"
                class="nav-link font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Lacak Pesanan
            </a>
        </div>

        <div class="flex items-center gap-6">
            <span class="material-symbols-outlined text-primary-container cursor-pointer">shopping_cart</span>
            <button
                class="bg-primary-container text-on-primary-container px-6 py-2 rounded-full font-label-md text-label-md font-bold active:scale-95 duration-100">
                Pesan Sekarang
            </button>
        </div>
    </div>
</nav>

<!-- Mobile TopNavBar -->
<nav
    class="bg-secondary sticky top-0 z-50 shadow-sm md:hidden flex justify-between items-center w-full px-margin-mobile py-3">
    <div class="font-headline-lg-mobile text-headline-lg-mobile font-bold text-primary-container">
        Soto Lamongan
    </div>
    <div class="flex items-center gap-4">
        <span class="material-symbols-outlined text-primary-container">shopping_cart</span>
        <span class="material-symbols-outlined text-primary-container">menu</span>
    </div>
</nav>
