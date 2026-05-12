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

                {{-- Nama Lengkap --}}
                <div class="mb-5">
                    <label for="name" class="input-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="input-field @error('name') !border-red-400 !ring-red-400/20 @enderror" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                    @error('name') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Username & Email --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="username" class="input-label">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username" class="input-field @error('username') !border-red-400 !ring-red-400/20 @enderror" placeholder="Username" value="{{ old('username') }}" required>
                        @error('username') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="email" class="input-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" class="input-field @error('email') !border-red-400 !ring-red-400/20 @enderror" placeholder="email@example.com" value="{{ old('email') }}" required>
                        @error('email') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Password --}}
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

                {{-- Tanggal Lahir & No. Telepon --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="tanggal_lahir" class="input-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="input-field @error('tanggal_lahir') !border-red-400 !ring-red-400/20 @enderror" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="phone" class="input-label">No. Telepon <span class="text-red-500">*</span></label>
                        <input type="tel" name="phone" id="phone" class="input-field @error('phone') !border-red-400 !ring-red-400/20 @enderror" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                        @error('phone') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Jenis Kelamin & Golongan Darah --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="jenis_kelamin" class="input-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="input-field @error('jenis_kelamin') !border-red-400 !ring-red-400/20 @enderror" required>
                            <option value="" disabled {{ old('jenis_kelamin') == '' ? 'selected' : '' }}>Pilih jenis kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="golongan_darah" class="input-label">Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="input-field @error('golongan_darah') !border-red-400 !ring-red-400/20 @enderror">
                            <option value="" disabled {{ old('golongan_darah') == '' ? 'selected' : '' }}>Pilih golongan darah</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        @error('golongan_darah') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Tinggi Badan & Berat Badan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="tinggi_badan" class="input-label">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" class="input-field @error('tinggi_badan') !border-red-400 !ring-red-400/20 @enderror" placeholder="Contoh: 165" value="{{ old('tinggi_badan') }}" min="50" max="250" step="0.1" required>
                        @error('tinggi_badan') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="berat_badan" class="input-label">Berat Badan (kg) <span class="text-red-500">*</span></label>
                        <input type="number" name="berat_badan" id="berat_badan" class="input-field @error('berat_badan') !border-red-400 !ring-red-400/20 @enderror" placeholder="Contoh: 60" value="{{ old('berat_badan') }}" min="20" max="300" step="0.1" required>
                        @error('berat_badan') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Merokok & Riwayat Medis --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="merokok" class="input-label">Merokok <span class="text-red-500">*</span></label>
                        <select name="merokok" id="merokok" class="input-field @error('merokok') !border-red-400 !ring-red-400/20 @enderror" required>
                            <option value="" disabled {{ old('merokok') == '' ? 'selected' : '' }}>Pilih</option>
                            <option value="Tidak" {{ old('merokok') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                            <option value="Ya" {{ old('merokok') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        </select>
                        @error('merokok') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="riwayat_medis" class="input-label">Riwayat Medis</label>
                        <textarea name="riwayat_medis" id="riwayat_medis" rows="2" class="input-field @error('riwayat_medis') !border-red-400 !ring-red-400/20 @enderror" placeholder="Riwayat penyakit, alergi, atau kondisi medis lainnya...">{{ old('riwayat_medis') }}</textarea>
                        @error('riwayat_medis') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Provinsi & Kota --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="provinsi" class="input-label">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="provinsi" id="provinsi" class="input-field @error('provinsi') !border-red-400 !ring-red-400/20 @enderror" placeholder="Provinsi" value="{{ old('provinsi') }}" required>
                        @error('provinsi') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="kota" class="input-label">Kota / Kabupaten <span class="text-red-500">*</span></label>
                        <input type="text" name="kota" id="kota" class="input-field @error('kota') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kota / Kabupaten" value="{{ old('kota') }}" required>
                        @error('kota') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Kecamatan & Kelurahan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label for="kecamatan" class="input-label">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="kecamatan" id="kecamatan" class="input-field @error('kecamatan') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kecamatan" value="{{ old('kecamatan') }}" required>
                        @error('kecamatan') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="kelurahan" class="input-label">Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" name="kelurahan" id="kelurahan" class="input-field @error('kelurahan') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kelurahan" value="{{ old('kelurahan') }}" required>
                        @error('kelurahan') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Alamat & Kode Pos --}}
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-5 mb-6">
                    <div class="sm:col-span-3">
                        <label for="alamat" class="input-label">Alamat <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="2" class="input-field @error('alamat') !border-red-400 !ring-red-400/20 @enderror" placeholder="Alamat lengkap..." required>{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-1">
                        <label for="kode_pos" class="input-label">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_pos" id="kode_pos" class="input-field @error('kode_pos') !border-red-400 !ring-red-400/20 @enderror" placeholder="Kode pos" value="{{ old('kode_pos') }}" maxlength="5" required>
                        @error('kode_pos') <p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p> @enderror
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
