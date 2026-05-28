@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <label for="name" class="input-label">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                        class="input-field @error('name') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama lengkap"
                        required autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="input-label">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email"
                            class="input-field @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="username" class="input-label">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" id="username"
                            class="input-field @error('username') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            value="{{ old('username') }}"
                            placeholder="username"
                            required>
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="input-label">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password"
                                class="input-field @error('password') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                                placeholder="Minimal 6 karakter"
                                required>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="input-label">Ulangi Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="input-field"
                                placeholder="Ketik ulang password"
                                required>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="role" class="input-label">Role <span class="text-red-500">*</span></label>
                    <select name="role" id="role" class="input-field @error('role') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror" required>
                        <option value="">Pilih Role</option>
                        @foreach($availableRoles as $key => $label)
                            <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="desa-field" class="{{ in_array(old('role'), ['kepala_desa', 'kader']) ? '' : 'hidden' }}">
                    <label for="desa_id" class="input-label">Desa</label>
                    @if(Auth::user()->role === 'kepala_desa')
                        <input type="hidden" name="desa_id" value="{{ Auth::user()->desa_id }}">
                        <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->desa?->name ?? 'Desa tidak diketahui' }} (otomatis)</p>
                    @else
                    <select name="desa_id" id="desa_id" class="input-field @error('desa_id') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror">
                        <option value="">Pilih Desa</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ old('desa_id') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    @error('desa_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="input-label">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone"
                        class="input-field @error('phone') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('phone') }}"
                        placeholder="081234567890">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jk" class="input-label">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jk" id="jk" class="input-field @error('jk') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jk') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jk') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    Simpan Pengguna
                </button>
                <a href="{{ route('admin.users') }}" class="btn-white flex-1 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    document.getElementById('role').addEventListener('change', function() {
        const desaField = document.getElementById('desa-field');
        if (this.value === 'kepala_desa' || this.value === 'kader') {
            desaField.classList.remove('hidden');
        } else {
            desaField.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
