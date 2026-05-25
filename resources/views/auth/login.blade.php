@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        {{-- Logo & Brand --}}
        <div class="text-center mb-8">
            <img src="{{ asset('assets/images/logo.svg') }}" alt="Diamond Care" class="w-20 h-20 mx-auto mb-4">
            <h2 class="text-2xl font-extrabold text-gray-800">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-500 mt-1">Masuk ke akun Diamond Care Anda</p>
        </div>

        {{-- Session Success Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Session Error Message --}}
        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Login Card --}}
        <div class="card !p-8 !shadow-xl !shadow-gray-200/60">
            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                {{-- Username --}}
                <div class="mb-5">
                    <label for="username" class="input-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        id="username"
                        class="input-field @error('username') !border-red-400 !ring-red-400/20 @enderror"
                        placeholder="Masukkan username Anda"
                        value="{{ old('username') }}"
                        required
                        autofocus
                    >
                    @error('username')
                        <p class="mt-1.5 text-sm text-red-500 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-2">
                    <label for="password" class="input-label">Kata Sandi</label>
                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="input-field pr-12 @error('password') !border-red-400 !ring-red-400/20 @enderror"
                            placeholder="Masukkan kata sandi"
                            required
                        >
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                            <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="password-eye-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-sm text-red-500 font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Forgot Password --}}
                <div class="flex justify-end mb-6">
                    <a href="{{ route('forgot-password') }}" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                        Lupa Kata Sandi?
                    </a>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full !py-3.5 !text-base !rounded-2xl">
                    Masuk
                </button>
            </form>

            {{-- Divider --}}
            {{-- <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-3 bg-white text-gray-400">atau</span>
                </div>
            </div> --}}

            {{-- Register Link --}}
            {{-- <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">
                    Daftar sekarang
                </a>
            </p> --}}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eye = btn.querySelector('#password-eye');
        const eyeOff = btn.querySelector('#password-eye-off');
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.add('hidden');
            eyeOff.classList.remove('hidden');
        } else {
            input.type = 'password';
            eye.classList.remove('hidden');
            eyeOff.classList.add('hidden');
        }
    }
</script>
@endpush
@endsection
