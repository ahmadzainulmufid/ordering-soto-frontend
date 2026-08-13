<!-- Desktop TopNavBar -->
<nav class="bg-secondary sticky top-0 z-50 shadow-md hidden md:block">
    <div class="flex justify-between items-center w-full px-margin-desktop py-4">
        <div class="font-display-lg text-display-lg font-bold text-primary-container">
            Soto Lamongan
        </div>

        <!-- Navigasi Links -->
        <div class="flex items-center gap-8">
            <a href="{{ url('/') }}"
                class="font-label-md text-label-md pb-1 transition-all {{ request()->is('/') ? 'text-primary-container border-b-2 border-primary-container font-bold' : 'text-on-secondary hover:text-primary-container' }}">
                Beranda
            </a>
            <a href="{{ url('/menu') }}"
                class="font-label-md text-label-md pb-1 transition-all {{ request()->is('menu') ? 'text-primary-container border-b-2 border-primary-container font-bold' : 'text-on-secondary hover:text-primary-container' }}">
                Menu
            </a>
            <a href="{{ url('/#order') }}"
                class="font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Cara Pesan
            </a>
            <a href="{{ url('/#lokasi') }}"
                class="font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
                Lokasi
            </a>
            <a href="#"
                class="font-label-md text-label-md text-on-secondary hover:text-primary-container pb-1 transition-all">
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
