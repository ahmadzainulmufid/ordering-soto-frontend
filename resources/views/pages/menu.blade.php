@extends('layouts.app')

@section('title', 'Menu - Soto Lamongan Cak Mufid')

@section('content')
    <div class="px-margin-desktop py-12">
        <!-- Header Section -->
        <header class="mb-12">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <h1 class="font-headline-lg text-headline-lg text-primary mb-2">Menu Kami</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                        Nikmati kelezatan Soto Lamongan otentik dengan koya gurih dan pilihan sate pelengkap terbaik dari
                        dapur Cak Mufid.
                    </p>
                </div>
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline"
                        data-icon="search">search</span>
                    <input
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border-none focus:ring-2 focus:ring-primary-container font-body-md text-body-md"
                        placeholder="Cari menu favorit Anda..." type="text" />
                </div>
            </div>

            <!-- Category Filters -->
            <div class="flex flex-wrap gap-3">
                <button
                    class="px-6 py-2 rounded-full bg-primary-container text-on-primary-container font-label-md text-label-md font-bold shadow-sm">Semua</button>
                <button
                    class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md">Soto</button>
                <button
                    class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md">Makanan
                    Tambahan</button>
                <button
                    class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md">Sate</button>
                <button
                    class="px-6 py-2 rounded-full bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors font-label-md text-label-md">Minuman</button>
            </div>
        </header>

        <!-- Layout Grid -->
        <div class="grid grid-cols-12 gap-gutter">
            <!-- Left: Menu Grid (9 cols) -->
            <section class="col-span-12 lg:col-span-9">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">

                    <!-- Menu Item 1: Soto Ayam Lamongan -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCvzuQlNUY3gv4y7gdc6uWK5uDxi6Ij9AXGC9RFWTD1iOo2N8S3pV3YTIDSapdU2G719kracjsOW0s8s5We1Lpv1PSFADIsNWFbFPZBzoZP44neuK_OQW7IrhRM-5rSSBNn2q5jpbYd1Ups6FhpCvQfuatyMXceyHb_oGJ1LMVa9GyF4dO8USRek7GAwmhvJhQkM8HFERAxtPnu0n6Y8fNNeMpCTjSMNMRpawvsi9p8fu-tuFMS4iA4poShtr4jHdsq0r7624KctTRt"
                                alt="Soto Ayam Lamongan" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Soto Ayam Lamongan</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 18.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Kuah kuning
                                bening gurih dengan suwiran ayam kampung dan koya spesial.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 2: Soto Ayam Spesial -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB0Mfd2JfNeKwy-SxdedkpKDNI1ZnndJPJe11xxyR5da7vE8lTZqJwPqlRAdfXP6SQwJoqxJ-xVwq3tjBGWBT8ierh3SnesoVnMRBpmpUtaCzMqB9gge0E9ChoAZSGm9vTzNMypEK58TD-gd2k7Eyd4p3kKJlXMo_VTjJjsT-Xk4E8v16k7eqIMdVbPC-4xc97iPjTMlik9WYM3g8oBYcpCq8AdrZev7IGGTAY9D325Swo5H47C_yKN6glwXEN1Um4NFKDXvRJ8NlKE"
                                alt="Soto Ayam Spesial" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Soto Ayam Spesial</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 25.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Porsi lebih besar
                                dengan tambahan telur utuh dan suwiran ayam ekstra.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 3: Soto Ayam + Nasi -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAwSldel_Rhj9F4tbbnb9QRwcZJinqZEhEJ1cHZdRSW4V1cZ9-1cuvvtgcfmI6UBw2scOhqNWi870z5sy3tfbpf2k3kgzNoDWXCKF00qSukJgOHy0krVMQ632RcbLGH367yEyNrjIYsM8H4cwLL68Pc8o8pOFzPQaH0ySNR6jJyFJxhSXXDn6aF3qD0lvQIvFSaf6k5kTm6w1R5NNYvUb_oPzIQCfNl3A7S_kZNs008azwx9nERC0A3xPA7EXa6ax3iXInxNNS5TFl"
                                alt="Soto Ayam + Nasi" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Soto Ayam + Nasi</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 22.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Paket hemat Soto
                                Ayam Lamongan lengkap dengan nasi putih hangat.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 4: Sate Usus -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlTgRnPRNvw-PaM6YEeE6bBDd4SpPlNFRcwV_FzRWIkyCr9zUBItWwuVoKZS626YrTftOeNMrLTgyMr-YOeS7rFPelVj12eRnsdgtyUAjqBFCPOSAnS7R3LaVn5WeP4YFayW4rlHYl0jeCct_288eH0KQcsCflZRHjDGxWWM-ztDOSunC0otr-3u7sZpvDo6jO5Nkoq1EfDtM6-kEa_-ff90PTW6X_yxFS61P4C3rSq55bt3Hh6jjkhPKfdxei4tHKV8ArgYn9ytmx"
                                alt="Sate Usus" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Sate Usus</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 3.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Sate usus bumbu
                                kecap manis gurih, pelengkap sempurna soto Anda.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 5: Sate Telur Puyuh -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXwhgRxGpDlDY_VveaQX0RUnepXzSSBLSTeagLfObdevhPvGwyPimvL-Uha75AlmtOvBMnaEDR8xM6a762H5asZHcMqriM5ArFZC25dx4_c1dD4T5vw2eCb3szfKtaspX9Akbj19waeWx3wl4KWGc7BvmFY71d_hDWl_Ll0PbVYs7JvMesEEIcKFnw6N_dO_uM_vH8T32I023xYFmCrafLZ9_en1scs3XvKEwkw-9ZW564mCuj8DWphoAXXNRKX3JVeSCubxlJZOL7"
                                alt="Sate Telur Puyuh" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Sate Telur Puyuh</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 4.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Telur puyuh
                                pilihan dimasak dengan bumbu bacem tradisional.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 6: Es Teh Manis -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWrIW0AbvuomIGaDugGZKqJifaRBAsrxzE6Em92plammVI8uar09OSNaIOH5is4F44N_4ClVEFybyWkH6cxq7fABDfqlPWTXw359XKjlUcfxtRT19Hx-ghSL_zc6LvX1dGZHoLxF8sOHagD5_IQysAC-WVlh8JftH9ZpFjQCEaCvaEFUVzhsPmx_uUEp5yZHnStsil-YRdttqFxZxan76o_grcKeD7Gy7O62m3rxnJx7LuM2d78OJMykeNYnvSghFSCZVxLkf6AXvZ"
                                alt="Es Teh Manis" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Es Teh Manis</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 5.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Teh melati wangi
                                disajikan dingin dengan gula murni.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                    <!-- Menu Item 7: Es Jeruk -->
                    <div
                        class="menu-card bg-surface-bright rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="h-48 w-full overflow-hidden">
                            <img class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBNAKE350axJmQVxdgyWbo3y6xxSEb7l8yJZ61DW4Z0iBkAC0pPnJ0j67OXI6ldtpc6DtMcxPiRnm4P4bp07VRZ0rwYzjkBFwOXTtp-kqivjm4ZuN_fZ7qbX4NNRXK6apEVlpBDfs-bdUE3LSo_I6x2npmaHxGkvhYm4LyWjNA3sBwr5WhH2m5OJQJLfCDj83zwUT71f6N0E9BCvPUREiwSfVyevDvkPCSko_MzDxi6UxOQj5om8lsp7LmdnWag-YJwh7eT54EK6Dog"
                                alt="Es Jeruk" />
                        </div>
                        <div class="p-5 grow flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-title-md text-title-md text-on-surface">Es Jeruk</h3>
                                <span class="font-label-md text-label-md text-secondary font-bold">Rp 8.000</span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-2">Perasan jeruk
                                segar murni kaya vitamin C, segar dan sehat.</p>
                            <button
                                class="mt-auto w-full py-3 bg-secondary text-white rounded-lg font-label-md text-label-md font-bold flex items-center justify-center gap-2 active:opacity-80 transition-opacity">
                                <span class="material-symbols-outlined text-sm" data-icon="add">add</span> Tambah
                            </button>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Right: Sticky Cart Summary (3 cols) -->
            <aside class="col-span-12 lg:col-span-3">
                <div class="sticky top-28 bg-surface-container-high rounded-2xl p-6 shadow-md flex flex-col h-fit">
                    <div class="flex items-center gap-2 mb-6 text-primary">
                        <span class="material-symbols-outlined" data-icon="shopping_basket">shopping_basket</span>
                        <h2 class="font-title-md text-title-md">Ringkasan Pesanan</h2>
                    </div>

                    <!-- Selected Items List -->
                    <div class="space-y-4 mb-8 max-h-100 overflow-y-auto custom-scrollbar pr-2">
                        <!-- Item 1 -->
                        <div class="flex justify-between items-start gap-4">
                            <div class="grow">
                                <h4 class="font-label-md text-label-md text-on-surface">Soto Ayam Lamongan</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="remove">remove</span>
                                    </button>
                                    <span class="font-label-md text-label-md">1</span>
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="add">add</span>
                                    </button>
                                </div>
                            </div>
                            <span class="font-label-md text-label-md text-on-surface whitespace-nowrap">Rp 18.000</span>
                        </div>
                        <!-- Item 2 -->
                        <div class="flex justify-between items-start gap-4">
                            <div class="grow">
                                <h4 class="font-label-md text-label-md text-on-surface">Sate Telur Puyuh</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="remove">remove</span>
                                    </button>
                                    <span class="font-label-md text-label-md">2</span>
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="add">add</span>
                                    </button>
                                </div>
                            </div>
                            <span class="font-label-md text-label-md text-on-surface whitespace-nowrap">Rp 8.000</span>
                        </div>
                        <!-- Item 3 -->
                        <div class="flex justify-between items-start gap-4">
                            <div class="grow">
                                <h4 class="font-label-md text-label-md text-on-surface">Es Teh Manis</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="remove">remove</span>
                                    </button>
                                    <span class="font-label-md text-label-md">1</span>
                                    <button
                                        class="w-6 h-6 rounded bg-outline-variant/30 flex items-center justify-center text-on-surface hover:bg-outline-variant/50 transition-colors">
                                        <span class="material-symbols-outlined text-xs" data-icon="add">add</span>
                                    </button>
                                </div>
                            </div>
                            <span class="font-label-md text-label-md text-on-surface whitespace-nowrap">Rp 5.000</span>
                        </div>
                    </div>

                    <!-- Pricing Info -->
                    <div class="border-t border-outline-variant pt-6 space-y-3 mb-8">
                        <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
                            <span>Subtotal</span>
                            <span>Rp 31.000</span>
                        </div>
                        <div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
                            <span>Biaya Layanan</span>
                            <span>Rp 2.000</span>
                        </div>
                        <div
                            class="flex justify-between font-title-md text-title-md text-on-surface pt-2 border-t border-dashed border-outline-variant">
                            <span>Total</span>
                            <span class="text-secondary">Rp 33.000</span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button
                        class="w-full py-4 bg-primary-container text-on-primary-container font-label-md text-label-md font-bold rounded-xl shadow-lg hover:shadow-xl transition-all active:scale-95 flex items-center justify-center gap-2">
                        Lanjut ke Checkout <span class="material-symbols-outlined"
                            data-icon="arrow_forward">arrow_forward</span>
                    </button>
                    <p class="mt-4 text-center text-xs text-on-surface-variant italic">Pesanan akan segera diproses setelah
                        konfirmasi pembayaran.</p>
                </div>
            </aside>
        </div>
    </div>
@endsection
