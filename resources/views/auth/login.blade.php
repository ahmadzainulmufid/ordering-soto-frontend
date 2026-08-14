<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - Soto Lamongan Joko Tingkir</title>

    {{-- Panggil Style & Asset --}}
    @include('includes.style')
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex items-center justify-center p-4">

    <!-- Card Login -->
    <div
        class="w-full max-w-md bg-surface-bright rounded-2xl shadow-xl border border-outline-variant/30 overflow-hidden">

        <!-- Header / Brand -->
        <div class="bg-secondary p-8 text-center relative">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-primary-container text-xs font-label-md mb-4 hover:underline">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Beranda
            </a>
            <h1 class="font-display-lg text-title-md md:text-headline-lg font-bold text-primary-container">
                Soto Lamongan
            </h1>
            <p class="text-on-secondary text-label-sm font-normal mt-1 opacity-90">
                Portal Masuk Admin & Pengelola
            </p>
        </div>

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Flash Message Error -->
            @if (session('error'))
                <div
                    class="bg-error-container text-on-error-container p-4 rounded-xl text-label-md flex items-center gap-3">
                    <span class="material-symbols-outlined text-error">error</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Input Email -->
            <div class="space-y-2">
                <label for="email" class="block font-label-md text-label-md text-on-surface">
                    Alamat Email
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        mail
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="admin@sotolamongan.com"
                        class="w-full pl-12 pr-4 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />
                </div>
                @error('email')
                    <span class="text-error text-label-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Input Password dengan Toggle Mata -->
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label for="password" class="block font-label-md text-label-md text-on-surface">
                        Kata Sandi
                    </label>
                </div>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-lg select-none">
                        lock
                    </span>
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        class="w-full pl-12 pr-12 py-3 bg-surface-container rounded-xl border border-transparent focus:border-primary-container focus:bg-surface-bright focus:ring-2 focus:ring-primary-container font-body-md text-body-md text-on-surface transition-all outline-none" />

                    <!-- Tombol Toggle Mata -->
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

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}
                        class="w-4 h-4 rounded border-outline text-secondary focus:ring-secondary accent-secondary cursor-pointer" />
                    <span class="font-body-md text-label-md text-on-surface-variant">Ingat Saya</span>
                </label>
            </div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full py-3.5 bg-primary-container text-on-primary-container font-label-md text-label-md font-bold rounded-xl shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                <span>Masuk Dashboard</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </form>

        <!-- Footer Card -->
        <div class="bg-surface-container-low px-8 py-4 text-center border-t border-outline-variant/30">
            <p class="text-label-sm text-on-surface-variant">
                &copy; {{ date('Y') }} Soto Lamongan Joko Tingkir. Admin System.
            </p>
        </div>

    </div>

    {{-- Script Asset --}}
    @include('includes.script')

    <!-- Script Toggle Password -->
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
