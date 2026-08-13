<div id="logoutModal"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-center justify-center hidden transition-all duration-300">
    <div class="bg-surface-bright rounded-2xl p-6 max-w-sm w-full mx-4 shadow-2xl border border-outline-variant/30 transform transition-all scale-95"
        id="logoutModalCard">

        <div
            class="w-12 h-12 bg-tertiary-container/30 text-tertiary rounded-2xl flex items-center justify-center mb-4 mx-auto">
            <span class="material-symbols-outlined text-2xl">logout</span>
        </div>

        <div class="text-center space-y-2 mb-6">
            <h3 class="font-title-md text-title-md font-bold text-on-surface">Konfirmasi Keluar</h3>
            <p class="font-body-md text-sm text-on-surface-variant">Apakah Anda yakin ingin keluar dari halaman admin
                Soto Lamongan?</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Batal -->
            <button type="button" onclick="closeLogoutModal()"
                class="flex-1 py-2.5 px-4 rounded-xl border border-outline-variant text-on-surface font-label-md font-medium hover:bg-surface-container transition-colors">
                Batal
            </button>
            <!-- Ya, Logout -->
            <a href="{{ route('logout') }}"
                class="flex-1 py-2.5 px-4 rounded-xl bg-tertiary text-on-tertiary text-center font-label-md font-bold hover:bg-tertiary/90 transition-all shadow-md">
                Ya, Keluar
            </a>
        </div>
    </div>
</div>

<!-- Script Kontrol Modal Pop-up -->
<script>
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        const card = document.getElementById('logoutModalCard');
        modal.classList.remove('hidden');
        setTimeout(() => {
            card.classList.remove('scale-95');
            card.classList.add('scale-100');
        }, 10);
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        const card = document.getElementById('logoutModalCard');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }

    // Close modal saat klik di luar kotak modal
    window.addEventListener('click', (e) => {
        const modal = document.getElementById('logoutModal');
        if (e.target === modal) {
            closeLogoutModal();
        }
    });
</script>
