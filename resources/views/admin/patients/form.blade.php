@extends('layouts.app')

@section('title', isset($patient) && $patient->id ? 'Edit Pasien' : 'Tambah Pasien')
@section('page-title', isset($patient) && $patient->id ? 'Edit Pasien' : 'Tambah Pasien')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <div class="w-10 h-10 rounded-xl gradient-pink flex items-center justify-center shadow-lg">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-800">{{ isset($patient) && $patient->id ? 'Edit Data Pasien' : 'Tambah Pasien Baru' }}</h3>
            <p class="text-sm text-gray-400">Lengkapi data member, alamat, dan kesehatan</p>
        </div>
    </div>

    <form action="{{ isset($patient) && $patient->id ? route('admin.patients.update', $patient->id) : route('admin.patients.store') }}" method="POST">
        @csrf
        @if(isset($patient) && $patient->id)
            @method('PUT')
        @endif

        {{-- Section 1: Data Member --}}
        <div class="card mb-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-primary-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Data Member</h4>
                    <p class="text-xs text-gray-400">Informasi dasar pasien</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="name" class="input-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" class="input-field @error('name') !border-red-400 @enderror" placeholder="Masukkan nama lengkap" value="{{ old('name', $patient->name ?? '') }}" required autofocus>
                    @error('name')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="birthdate" class="input-label">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="birthdate" id="birthdate" class="input-field @error('birthdate') !border-red-400 @enderror" value="{{ old('birthdate', isset($patient->birthdate) ? \Carbon\Carbon::parse($patient->birthdate)->format('Y-m-d') : '') }}" required>
                        @error('birthdate')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jk" class="input-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="jk" id="jk" class="input-field @error('jk') !border-red-400 @enderror" required>
                            <option value="" disabled {{ old('jk', $patient->jk ?? '') == '' ? 'selected' : '' }}>Pilih</option>
                            <option value="L" {{ old('jk', $patient->jk ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jk', $patient->jk ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jk')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="input-label">Telp</label>
                        <input type="tel" name="phone" id="phone" class="input-field @error('phone') !border-red-400 @enderror" placeholder="0812..." value="{{ old('phone', $patient->phone ?? '') }}" maxlength="15">
                        @error('phone')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Alamat --}}
        <div class="card mb-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Alamat</h4>
                    <p class="text-xs text-gray-400">Lokasi tempat tinggal pasien</p>
                </div>
            </div>

            <div class="space-y-4">
                @if($showDesaField)
                <div>
                    <label for="desa_id" class="input-label">Desa <span class="text-red-500">*</span></label>
                    <select name="desa_id" id="desa_id" class="input-field @error('desa_id') !border-red-400 @enderror" required>
                        <option value="">Pilih Desa</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id', $patient->desa_id ?? $autoDesaId) == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                        @endforeach
                    </select>
                    @error('desa_id')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>
                @else
                    <input type="hidden" name="desa_id" id="desa_id" value="{{ $autoDesaId }}">
                @endif

                <div>
                    <label for="kader_id" class="input-label">Kader Penanganan</label>
                    <select name="kader_id" id="kader_id" class="input-field @error('kader_id') !border-red-400 @enderror">
                        <option value="">Pilih Kader</option>
                        @foreach($kaders as $kader)
                            <option value="{{ $kader->id }}" {{ old('kader_id', $patient->kader_id ?? '') == $kader->id ? 'selected' : '' }}>{{ $kader->name }}</option>
                        @endforeach
                    </select>
                    @error('kader_id')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="address" class="input-label">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="address" id="address" rows="2" class="input-field @error('address') !border-red-400 @enderror" placeholder="Alamat lengkap..." required>{{ old('address', $patient->address ?? '') }}</textarea>
                    @error('address')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="province" class="input-label">Provinsi <span class="text-red-500">*</span></label>
                        <input type="text" name="province" id="province" class="input-field @error('province') !border-red-400 @enderror" placeholder="Provinsi" value="{{ old('province', $patient->province ?? '') }}" required>
                        @error('province')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="city" class="input-label">Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="city" id="city" class="input-field @error('city') !border-red-400 @enderror" placeholder="Kota" value="{{ old('city', $patient->city ?? '') }}" required>
                        @error('city')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <label for="subdistrict" class="input-label">Kecamatan <span class="text-red-500">*</span></label>
                        <input type="text" name="subdistrict" id="subdistrict" class="input-field @error('subdistrict') !border-red-400 @enderror" placeholder="Kecamatan" value="{{ old('subdistrict', $patient->subdistrict ?? '') }}" required>
                        @error('subdistrict')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="village" class="input-label">Kelurahan <span class="text-red-500">*</span></label>
                        <input type="text" name="village" id="village" class="input-field @error('village') !border-red-400 @enderror" placeholder="Kelurahan" value="{{ old('village', $patient->village ?? '') }}" required>
                        @error('village')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="kode_pos" class="input-label">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="kode_pos" id="kode_pos" class="input-field @error('kode_pos') !border-red-400 @enderror" placeholder="Kode pos" value="{{ old('kode_pos', $patient->kode_pos ?? '') }}" maxlength="5" required>
                        @error('kode_pos')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Kesehatan --}}
        <div class="card mb-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Kesehatan</h4>
                    <p class="text-xs text-gray-400">Data fisik & riwayat medis</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="blood" class="input-label">Golongan Darah <span class="text-red-500">*</span></label>
                        <select name="blood" id="blood" class="input-field @error('blood') !border-red-400 @enderror" required>
                            <option value="" disabled {{ old('blood', $patient->blood ?? '') == '' ? 'selected' : '' }}>Pilih</option>
                            <option value="O" {{ old('blood', $patient->blood ?? '') == 'O' ? 'selected' : '' }}>O</option>
                            <option value="A" {{ old('blood', $patient->blood ?? '') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('blood', $patient->blood ?? '') == 'B' ? 'selected' : '' }}>B</option>
                            <option value="AB" {{ old('blood', $patient->blood ?? '') == 'AB' ? 'selected' : '' }}>AB</option>
                        </select>
                        @error('blood')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="tall" class="input-label">Tinggi (cm) <span class="text-red-500">*</span></label>
                        <input type="number" name="tall" id="tall" class="input-field @error('tall') !border-red-400 @enderror" placeholder="165" value="{{ old('tall', $patient->tall ?? '') }}" required>
                        @error('tall')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="weight" class="input-label">Berat (kg) <span class="text-red-500">*</span></label>
                        <input type="number" name="weight" id="weight" class="input-field @error('weight') !border-red-400 @enderror" placeholder="60" value="{{ old('weight', $patient->weight ?? '') }}" required>
                        @error('weight')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="is_smoke" class="input-label">Perokok <span class="text-red-500">*</span></label>
                    <select name="is_smoke" id="is_smoke" class="input-field @error('is_smoke') !border-red-400 @enderror" required>
                        <option value="" disabled {{ old('is_smoke', ($patient->is_smoke ?? null) === null ? 'selected' : '') }}>Pilih</option>
                        <option value="0" {{ old('is_smoke', $patient->is_smoke ?? null) === '0' || old('is_smoke', $patient->is_smoke ?? null) === 0 ? 'selected' : '' }}>Tidak Merokok</option>
                        <option value="1" {{ old('is_smoke', $patient->is_smoke ?? null) === '1' || old('is_smoke', $patient->is_smoke ?? null) === 1 ? 'selected' : '' }}>Merokok</option>
                    </select>
                    @error('is_smoke')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="medical_history" class="input-label">Riwayat Penyakit</label>
                    <textarea name="medical_history" id="medical_history" rows="2" class="input-field @error('medical_history') !border-red-400 @enderror" placeholder="Riwayat penyakit, alergi, atau kondisi medis...">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
                    @error('medical_history')<p class="mt-1.5 text-sm text-red-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <button type="submit" class="btn-primary flex-1 !py-3 !text-base">
                <svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ isset($patient) && $patient->id ? 'Simpan Perubahan' : 'Simpan Pasien' }}
            </button>
            <a href="{{ route('admin.patients.index') }}" class="btn-white flex-1 sm:flex-none text-center !py-3 !text-base">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
(function() {
    const desaSelect = document.getElementById('desa_id');
    const kaderSelect = document.getElementById('kader_id');
    if (!desaSelect || !kaderSelect) return;

    const kaderRoute = '{{ route('admin.kader.by.desa', ['desaId' => '__DESA_ID__']) }}';
    const savedKaderId = '{{ old('kader_id', $patient->kader_id ?? '') }}';

    function populateKaders(kaders, selectedId) {
        kaderSelect.innerHTML = kaders.length
            ? '<option value="">Pilih Kader</option>'
            : '<option value="">Tidak ada kader</option>';
        kaders.forEach(function(k) {
            const option = document.createElement('option');
            option.value = k.id;
            option.textContent = k.name;
            if (k.id == selectedId) option.selected = true;
            kaderSelect.appendChild(option);
        });
    }

    function loadKaders(desaId, selectedId) {
        if (!desaId) {
            kaderSelect.innerHTML = '<option value="">Pilih Desa terlebih dahulu</option>';
            return;
        }
        kaderSelect.innerHTML = '<option value="">Memuat...</option>';
        kaderSelect.disabled = true;

        fetch(kaderRoute.replace('__DESA_ID__', desaId))
            .then(function(res) { return res.json(); })
            .then(function(data) { populateKaders(data, selectedId); })
            .catch(function() { kaderSelect.innerHTML = '<option value="">Gagal memuat kader</option>'; })
            .finally(function() { kaderSelect.disabled = false; });
    }

    desaSelect.addEventListener('change', function() {
        loadKaders(this.value, null);
    });

    const autoDesaId = '{{ $autoDesaId }}';
    if (autoDesaId) {
        loadKaders(autoDesaId, savedKaderId);
    }
})();
</script>
@endpush
