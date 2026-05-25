@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.users.detail', $user->id) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali
        </a>
        <a href="{{ route('admin.users') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
            Daftar Pengguna
        </a>
    </div>

    <div class="card">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-full gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/30 shrink-0">
                <span class="text-2xl font-extrabold text-white">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-400">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="input-label" for="role">Role</label>
                    <select name="role" id="role" class="input-field" required>
                        <option value="superadmin" {{ $user->role === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                        <option value="kepala_puskesmas" {{ $user->role === 'kepala_puskesmas' ? 'selected' : '' }}>Kepala Puskesmas</option>
                        <option value="kepala_desa" {{ $user->role === 'kepala_desa' ? 'selected' : '' }}>Kepala Desa</option>
                        <option value="kader" {{ $user->role === 'kader' ? 'selected' : '' }}>Kader</option>
                        <option value="pasien" {{ $user->role === 'pasien' ? 'selected' : '' }}>Pasien</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="desa-field" class="{{ in_array($user->role, ['kepala_desa', 'kader']) ? '' : 'hidden' }}">
                    <label class="input-label" for="desa_id">Desa</label>
                    <select name="desa_id" id="desa_id" class="input-field">
                        <option value="">Pilih Desa</option>
                        @php $desas = \App\Models\Desa::orderBy('name')->get(); @endphp
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id }}" {{ $user->desa_id == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                        @endforeach
                    </select>
                    @error('desa_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="input-label" for="email_verified_at">Status Verifikasi Email</label>
                    <select name="email_verified_at" id="email_verified_at" class="input-field">
                        <option value="0" {{ !$user->email_verified_at ? 'selected' : '' }}>Belum Terverifikasi</option>
                        <option value="1" {{ $user->email_verified_at ? 'selected' : '' }}>Terverifikasi</option>
                    </select>
                    @error('email_verified_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    @if($user->email_verified_at)
                        <p class="text-xs text-gray-400 mt-1">Terverifikasi pada: {{ $user->email_verified_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" class="btn-primary flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.detail', $user->id) }}" class="btn-white">Batal</a>
                </div>
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
