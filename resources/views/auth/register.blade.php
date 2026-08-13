<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pendaftaran Akun - Soto Lamongan Cak Mufid</title>

    {{-- Asset Style & Tailwind --}}
    @include('includes.style')
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex items-center justify-center p-4 py-10">

    <!-- Card Register -->
    <div
        class="w-full max-w-md bg-surface-bright rounded-2xl shadow-xl border border-outline-variant/30 overflow-hidden">

        <!-- Header / Brand -->
        <div class="bg-secondary p-8 text-center relative">
            <h1 class="font-display-lg text-title-md md:text-headline-lg font-bold text-primary-container">
                Soto Lamongan
            </h1>
            <p class="text-on-secondary text-label-sm font-normal mt-1 opacity-90">
                Pendaftaran Akun Pengelola / Staf Baru
            </p>
        </div>

        <!-- Form Register -->
        <form action="{{ route('register.post') }}" method="POST" class="p-8 space-y-5">
            @csrf

            <!-- Flash Error -->
            @if (session('error'))
                <div
                    class="bg-error-container text-on-error-container p-4 rounded-xl text-label-md flex items-center gap-3">
                    <span class="material-symbols-outlined text-error">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Input Nama Lengkap -->
            <div class="space-y-1.5">
                <label for="full_name" class="block font-label-md text-label-md text-on-surface">
                    Nama Lengkap
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        person
                    </span>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                        autofocus placeholder="Cak Mufid"
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />
                </div>
                @error('full_name')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Email -->
            <div class="space-y-1.5">
                <label for="email" class="block font-label-md text-label-md text-on-surface">
                    Alamat Email
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        mail
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        placeholder="mufid@sotolamongan.com"
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />
                </div>
                @error('email')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Nomor HP -->
            <div class="space-y-1.5">
                <label for="phone" class="block font-label-md text-label-md text-on-surface">
                    Nomor WhatsApp / HP
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        call
                    </span>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                        placeholder="081234567890"
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />
                </div>
                @error('phone')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Pilih Role -->
            <div class="space-y-1.5">
                <label for="role" class="block font-label-md text-label-md text-on-surface">
                    Peran / Role Akses
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        badge
                    </span>
                    <select id="role" name="role" required
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none appearance-none">
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Peran...</option>
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Pemilik (Owner)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin Operasional
                        </option>
                        <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : '' }}>Kasir (Cashier)
                        </option>
                        <option value="kitchen" {{ old('role') == 'kitchen' ? 'selected' : '' }}>Dapur (Kitchen)
                        </option>
                    </select>
                </div>
                @error('role')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Password dengan Toggle Mata -->
            <div class="space-y-1.5">
                <label for="password" class="block font-label-md text-label-md text-on-surface">
                    Kata Sandi
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        lock
                    </span>
                    <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter"
                        class="w-full pl-12 pr-12 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />

                    <button type="button" id="togglePassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary transition-colors focus:outline-none flex items-center justify-center">
                        <span class="material-symbols-outlined text-lg select-none" id="eyeIcon">
                            visibility_off
                        </span>
                    </button>
                </div>
                @error('password')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full py-3.5 bg-primary-container text-on-primary-container font-label-md text-label-md font-bold rounded-xl shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2 mt-4">
                <span>Daftar Akun</span>
                <span class="material-symbols-outlined text-sm">person_add</span>
            </button>
        </form>

        <!-- Footer Card -->
        <div class="bg-surface-container-low px-8 py-4 text-center border-t border-outline-variant/30">
            <p class="text-label-sm text-on-surface-variant">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-secondary font-bold hover:underline">Masuk
                    di sini</a>
            </p>
        </div>

    </div>

    {{-- Asset Script --}}
    @include('includes.script')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    eyeIcon.textContent = isPassword ? 'visibility' : 'visibility_off';
                });
            }
        });
    </script>
</body>

</html>
