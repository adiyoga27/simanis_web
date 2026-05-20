@extends('layouts.app')

@section('title', 'Ubah Kata Sandi')
@section('page-title', 'Ubah Kata Sandi')

@section('content')
<div class="max-w-xl mx-auto space-y-6">

    @if (session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Ubah Kata Sandi</h2>
                <p class="text-sm text-gray-400">Perbarui kata sandi akun Anda</p>
            </div>
        </div>

        <form action="{{ route('change.password.update') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="old_password" class="input-label">Kata Sandi Lama</label>
                <div class="relative">
                    <input type="password" name="old_password" id="old_password" class="input-field pr-12 @error('old_password') !border-red-400 !ring-red-400/20 @enderror" placeholder="Masukkan kata sandi lama" required>
                    <button type="button" onclick="togglePassword('old_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                        <svg class="w-5 h-5 eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-5 h-5 eye-off hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5"/></svg>
                    </button>
                </div>
                @error('old_password') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="new_password" class="input-label">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" class="input-field pr-12 @error('new_password') !border-red-400 !ring-red-400/20 @enderror" placeholder="Minimal 8 karakter" required>
                    <button type="button" onclick="togglePassword('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                        <svg class="w-5 h-5 eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-5 h-5 eye-off hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5"/></svg>
                    </button>
                </div>
                @error('new_password') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="new_password_confirmation" class="input-label">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="input-field pr-12 @error('new_password_confirmation') !border-red-400 !ring-red-400/20 @enderror" placeholder="Konfirmasi kata sandi baru" required>
                    <button type="button" onclick="togglePassword('new_password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                        <svg class="w-5 h-5 eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg class="w-5 h-5 eye-off hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5"/></svg>
                    </button>
                </div>
                @error('new_password_confirmation') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
            </div>

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('profile') }}" class="btn-white w-full sm:w-auto text-center">
                    Batal
                </a>
                <button type="submit" class="btn-primary w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Ubah Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const eye = btn.querySelector('.eye-on');
        const eyeOff = btn.querySelector('.eye-off');
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
