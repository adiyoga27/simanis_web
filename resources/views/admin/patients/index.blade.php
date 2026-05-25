@extends('layouts.app')

@section('title', 'Manajemen Pasien')
@section('page-title', 'Manajemen Pasien')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 text-red-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl gradient-pink flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Daftar Pasien</h3>
                <p class="text-xs text-gray-400">Total {{ $patients->total() }} pasien</p>
            </div>
        </div>
        <a href="{{ route('admin.patients.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pasien
        </a>
    </div>

    <div class="card space-y-3">
        <form method="GET" action="{{ route('admin.patients.index') }}">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, email, atau username..." class="input-field">
        </form>
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
        <form method="GET" action="{{ route('admin.patients.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="search" value="{{ $search ?? '' }}">
            <select name="desa_id" class="input-field !w-auto">
                <option value="">Semua Desa</option>
                @foreach($desas as $desa)
                    <option value="{{ $desa->id }}" {{ ($desaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary text-sm">Filter</button>
            @if($desaId ?? false)
                <a href="{{ route('admin.patients.index') }}" class="btn-white text-sm">Reset</a>
            @endif
        </form>
        @endif
    </div>

    <div class="card overflow-hidden !p-0">
        @if($patients->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Nama</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Telepon</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Desa</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Alamat</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($patients as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full gradient-pink flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <p class="font-medium text-gray-800">{{ $p->name }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->phone ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $p->desa?->name ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-500 max-w-[150px] truncate">{{ $p->address ?? '—' }}</td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.patients.edit', $p->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-green-50 text-green-700 text-xs font-semibold hover:bg-green-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.patients.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus pasien ini? Semua data terkait akan ikut terhapus.')" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 text-red-600 text-xs font-semibold hover:bg-red-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $patients->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada data pasien</p>
            <p class="text-gray-400 text-sm mt-1">
                @if($search)
                    Tidak ditemukan pasien dengan kata kunci "{{ $search }}"
                @else
                    Belum ada pasien terdaftar
                @endif
            </p>
        </div>
        @endif
    </div>

</div>
@endsection
