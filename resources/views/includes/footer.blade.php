<!-- Footer -->
<footer
    class="bg-inverse-surface dark:bg-surface-container-lowest text-primary-fixed w-full px-margin-mobile md:px-margin-desktop py-12 grid grid-cols-1 md:grid-cols-12 gap-gutter">

    <!-- Branding & Sosmed -->
    <div class="md:col-span-4 flex flex-col gap-6">
        <div class="font-title-md text-title-md text-primary-fixed">Soto Lamongan Joko Tingkir</div>
        <p class="font-body-md text-body-md text-surface-variant">
            Warisan rasa soto Lamongan otentik sejak 2010. Menggunakan rempah pilihan dan koya gurih resep rahasia
            keluarga.
        </p>
    </div>

    <!-- Navigasi Menu Utama -->
    <div class="md:col-span-2 flex flex-col gap-4">
        <h4 class="font-label-md text-label-md font-bold uppercase tracking-wider text-surface-variant">
            Menu Utama
        </h4>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container"
            href="{{ url('/#hero') }}">Beranda</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container"
            href="{{ url('/#menu') }}">Menu Kami</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container"
            href="{{ url('/#tentang') }}">Tentang Kami</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container"
            href="{{ url('/#lokasi') }}">Lokasi</a>
    </div>

    <!-- Navigasi Dukungan -->
    <div class="md:col-span-2 flex flex-col gap-4">
        <h4 class="font-label-md text-label-md font-bold uppercase tracking-wider text-surface-variant">
            Dukungan
        </h4>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container" href="#">Hubungi
            Kami</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container"
            href="#">Kebijakan Privasi</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container" href="#">Syarat
            &amp; Ketentuan</a>
        <a class="font-label-sm text-label-sm text-surface-variant hover:text-primary-container" href="#">FAQ</a>
    </div>

    <!-- Tentang Kami -->
    <div class="md:col-span-4 flex flex-col gap-4">
        <h4 class="font-label-md text-label-md font-bold uppercase tracking-wider text-surface-variant">
            Tentang Kami
        </h4>
        <p class="font-body-md text-body-md text-surface-variant">
            Berdiri sejak tahun 2010, Soto Lamongan Joko Tingkir berkomitmen menyajikan kehangatan resep soto khas Jawa
            Timur bagi warga Depok dan sekitarnya.
        </p>
        <p class="font-body-md text-body-md text-surface-variant">
            Mengutamakan kualitas bahan baku segar dan pelayanan ramah setiap harinya.
        </p>
    </div>

    <!-- Copyright -->
    <div
        class="md:col-span-12 border-t border-white/10 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="font-label-sm text-label-sm text-surface-variant">
            © {{ date('Y') }} Soto Lamongan Joko Tingkir.
        </div>
        <div class="flex gap-8">
            <span class="font-label-sm text-label-sm text-surface-variant">Bahasa Indonesia</span>
        </div>
    </div>
</footer>
