@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-xl">
        {{-- Logo & Brand --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 gradient-primary rounded-2xl shadow-xl shadow-primary-500/30 mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.698 50.698 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-800">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar dan mulai kelola diabetes Anda</p>
        </div>

        {{-- Validation Errors Summary --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Mohon perbaiki kesalahan berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 ml-7 text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Register Card --}}
        <div class="card !p-8 !shadow-xl !shadow-gray-200/60">
            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                {{-- ========== GROUP 1: Data Member ========== --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 mb-4 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700 uppercase tracking-wide">Data Member</span>
                    </div>

                    <div class="mb-5">
                        <label for="name" class="input-label">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="input-field @error('name') !border-red-400 !ring-red-400/20 @enderror" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                        @error('name') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="birthdate" class="input-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="birthdate" id="birthdate" class="input-field @error('birthdate') !border-red-400 !ring-red-400/20 @enderror" value="{{ old('birthdate') }}" required>
                            @error('birthdate') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="jk" class="input-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <select name="jk" id="jk" class="input-field @error('jk') !border-red-400 !ring-red-400/20 @enderror" required>
                                <option value="" disabled {{ old('jk') == '' ? 'selected' : '' }}>Pilih jenis kelamin</option>
                                <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jk') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="input-label">Telp</label>
                        <input type="tel" name="phone" id="phone" class="input-field @error('phone') !border-red-400 !ring-red-400/20 @enderror" placeholder="Masukkan nomor telp" value="{{ old('phone') }}" maxlength="15">
                        @error('phone') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- ========== GROUP 2: Alamat ========== --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 mb-4 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700 uppercase tracking-wide">Alamat <span class="text-red-500">*</span></span>
                    </div>

                    <div class="mb-5">
                        <label for="address" class="input-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="address" id="address" rows="2" class="input-field @error('address') !border-red-400 !ring-red-400/20 @enderror" placeholder="Alamat lengkap..." required>{{ old('address') }}</textarea>
                        @error('address') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="province" class="input-label">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" name="province" id="province" class="input-field @error('province') !border-red-400 !ring-red-400/20 @enderror" placeholder="Provinsi" value="{{ old('province') }}" required>
                            @error('province') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="city" class="input-label">Kota <span class="text-red-500">*</span></label>
                            <input type="text" name="city" id="city" class="input-field @error('city') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kota" value="{{ old('city') }}" required>
                            @error('city') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="subdistrict" class="input-label">Kecamatan <span class="text-red-500">*</span></label>
                            <input type="text" name="subdistrict" id="subdistrict" class="input-field @error('subdistrict') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kecamatan" value="{{ old('subdistrict') }}" required>
                            @error('subdistrict') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="village" class="input-label">Kelurahan <span class="text-red-500">*</span></label>
                            <input type="text" name="village" id="village" class="input-field @error('village') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kelurahan" value="{{ old('village') }}" required>
                            @error('village') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="kode_pos" class="input-label">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_pos" id="kode_pos" class="input-field @error('kode_pos') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kode pos" value="{{ old('kode_pos') }}" maxlength="5" required>
                        @error('kode_pos') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- ========== GROUP 3: Kesehatan ========== --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 mb-4 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700 uppercase tracking-wide">Kesehatan</span>
                    </div>

                    <div class="mb-5">
                        <label for="blood" class="input-label">Golongan Darah <span class="text-red-500">*</span></label>
                        <select name="blood" id="blood" class="input-field @error('blood') !border-red-400 !ring-red-400/20 @enderror" required>
                            <option value="" disabled {{ old('blood') == '' ? 'selected' : '' }}>Pilih golongan darah</option>
                            <option value="O" {{ old('blood') == 'O' ? 'selected' : '' }}>O</option>
                            <option value="A" {{ old('blood') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood') == 'AB' ? 'selected' : '' }}>AB</option>
                        </select>
                        @error('blood') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="tall" class="input-label">Tinggi Badan <span class="text-red-500">*</span></label>
                            <input type="text" name="tall" id="tall" class="input-field @error('tall') !border-red-400 !ring-red-400/20 @enderror" placeholder="Contoh: 165" value="{{ old('tall') }}" required>
                            @error('tall') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="weight" class="input-label">Berat Badan <span class="text-red-500">*</span></label>
                            <input type="text" name="weight" id="weight" class="input-field @error('weight') !border-red-400 !ring-red-400/20 @enderror" placeholder="Contoh: 60" value="{{ old('weight') }}" required>
                            @error('weight') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="is_smoke" class="input-label">Perokok <span class="text-red-500">*</span></label>
                        <select name="is_smoke" id="is_smoke" class="input-field @error('is_smoke') !border-red-400 !ring-red-400/20 @enderror" required>
                            <option value="" disabled {{ old('is_smoke') === null || old('is_smoke') === '' ? 'selected' : '' }}>Pilih</option>
                            <option value="0" {{ old('is_smoke') === '0' ? 'selected' : '' }}>Tidak Merokok</option>
                            <option value="1" {{ old('is_smoke') === '1' ? 'selected' : '' }}>Merokok</option>
                        </select>
                        @error('is_smoke') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="medical_history" class="input-label">Riwayat Penyakit</label>
                        <textarea name="medical_history" id="medical_history" rows="2" class="input-field @error('medical_history') !border-red-400 !ring-red-400/20 @enderror" placeholder="Riwayat penyakit, alergi, atau kondisi medis lainnya...">{{ old('medical_history') }}</textarea>
                        @error('medical_history') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- ========== GROUP 4: Akun ========== --}}
                <div class="mb-6">
                    <div class="flex items-center gap-2.5 mb-4 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700 uppercase tracking-wide">Akun <span class="text-red-500">*</span></span>
                    </div>

                    <div class="mb-5">
                        <label for="email" class="input-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" class="input-field @error('email') !border-red-400 !ring-red-400/20 @enderror" placeholder="email@example.com" value="{{ old('email') }}" required>
                        @error('email') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="username" class="input-label">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username" class="input-field @error('username') !border-red-400 !ring-red-400/20 @enderror" placeholder="Username" value="{{ old('username') }}" required>
                        @error('username') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="input-label">Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="input-field pr-12 @error('password') !border-red-400 !ring-red-400/20 @enderror" placeholder="Minimal 8 karakter" required>
                            <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                                <svg class="w-5 h-5 eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-5 h-5 eye-off hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5"/></svg>
                            </button>
                        </div>
                        @error('password') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="input-label">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="input-field pr-12 @error('password_confirmation') !border-red-400 !ring-red-400/20 @enderror" placeholder="Konfirmasi kata sandi" required>
                            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                                <svg class="w-5 h-5 eye-on" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="w-5 h-5 eye-off hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M15 12a3 3 0 00-3-3m0 0a9.97 9.97 0 015.542 2.029M5 19L19 5"/></svg>
                            </button>
                        </div>
                        @error('password_confirmation') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-primary w-full !py-3.5 !text-base !rounded-2xl">
                    Daftar
                </button>
            </form>

            {{-- Login Link --}}
            <p class="mt-6 text-center text-sm text-gray-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition-colors">
                    Masuk
                </a>
            </p>
        </div>
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
