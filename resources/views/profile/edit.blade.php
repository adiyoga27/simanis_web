@extends('layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
                <p class="text-sm text-gray-400">Perbarui informasi pribadi dan data kesehatan Anda</p>
            </div>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-1">
                <h3 class="text-sm font-semibold text-primary-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 gradient-primary rounded-full inline-block"></span>
                    Informasi Akun
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="input-label">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="input-field @error('name') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('name', $user->name) }}" placeholder="Nama lengkap Anda" required>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="input-label">Email</label>
                        <input type="email" name="email" id="email" class="input-field @error('email') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('email', $user->email) }}" placeholder="Alamat email" required>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="input-label">No. Telepon</label>
                        <input type="text" name="phone" id="phone" class="input-field @error('phone') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="birth_date" class="input-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" id="birth_date" class="input-field @error('birth_date') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <h3 class="text-sm font-semibold text-pink-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 gradient-pink rounded-full inline-block"></span>
                    Data Pribadi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="gender" class="input-label">Jenis Kelamin</label>
                        <select name="gender" id="gender" class="input-field @error('gender') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror">
                            <option value="" disabled selected>Pilih jenis kelamin</option>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="blood_type" class="input-label">Golongan Darah</label>
                        <select name="blood_type" id="blood_type" class="input-field @error('blood_type') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror">
                            <option value="" disabled selected>Pilih golongan darah</option>
                            <option value="A" {{ old('blood_type', $user->blood_type) == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood_type', $user->blood_type) == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood_type', $user->blood_type) == 'AB' ? 'selected' : '' }}>AB</option>
                            <option value="O" {{ old('blood_type', $user->blood_type) == 'O' ? 'selected' : '' }}>O</option>
                        </select>
                        @error('blood_type')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <h3 class="text-sm font-semibold text-green-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 bg-gradient-to-br from-green-400 to-green-500 rounded-full inline-block"></span>
                    Data Kesehatan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="height" class="input-label">Tinggi Badan (cm)</label>
                        <input type="number" name="height" id="height" class="input-field @error('height') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('height', $user->height) }}" placeholder="Contoh: 165" min="1" step="0.1">
                        @error('height')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="weight" class="input-label">Berat Badan (kg)</label>
                        <input type="number" name="weight" id="weight" class="input-field @error('weight') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('weight', $user->weight) }}" placeholder="Contoh: 60" min="1" step="0.1">
                        @error('weight')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="smoking" class="input-label">Merokok</label>
                        <select name="smoking" id="smoking" class="input-field @error('smoking') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror">
                            <option value="0" {{ old('smoking', $user->smoking) == '0' ? 'selected' : '' }}>Tidak</option>
                            <option value="1" {{ old('smoking', $user->smoking) == '1' ? 'selected' : '' }}>Ya</option>
                        </select>
                        @error('smoking')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="medical_history" class="input-label">Riwayat Medis</label>
                        <textarea name="medical_history" id="medical_history" rows="3" class="input-field @error('medical_history') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" placeholder="Contoh: Diabetes tipe 2, hipertensi...">{{ old('medical_history', $user->medical_history) }}</textarea>
                        @error('medical_history')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <h3 class="text-sm font-semibold text-indigo-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-full inline-block"></span>
                    Alamat
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="province" class="input-label">Provinsi</label>
                        <input type="text" name="province" id="province" class="input-field @error('province') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('province', $user->province) }}" placeholder="Masukkan provinsi">
                        @error('province')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="city" class="input-label">Kota</label>
                        <input type="text" name="city" id="city" class="input-field @error('city') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('city', $user->city) }}" placeholder="Masukkan kota">
                        @error('city')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="district" class="input-label">Kecamatan</label>
                        <input type="text" name="district" id="district" class="input-field @error('district') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('district', $user->district) }}" placeholder="Masukkan kecamatan">
                        @error('district')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="village" class="input-label">Kelurahan</label>
                        <input type="text" name="village" id="village" class="input-field @error('village') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('village', $user->village) }}" placeholder="Masukkan kelurahan">
                        @error('village')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="input-label">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="2" class="input-field @error('address') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" placeholder="Masukkan alamat lengkap">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="postal_code" class="input-label">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" class="input-field @error('postal_code') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror max-w-[200px]" value="{{ old('postal_code', $user->postal_code) }}" placeholder="Kode pos">
                        @error('postal_code')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
