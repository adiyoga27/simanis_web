@extends('layouts.app')

@section('title', 'Manajemen Desa')
@section('page-title', 'Manajemen Desa')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 text-red-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Desa</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola data desa yang terdaftar</p>
        </div>
        <a href="{{ route('admin.desa.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Desa
        </a>
    </div>

    @if($desas->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada data desa</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan data desa untuk mulai mengelola wilayah</p>
            <a href="{{ route('admin.desa.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Desa Pertama
            </a>
        </div>
    @else
        <!-- Mobile cards -->
        <div class="lg:hidden space-y-4">
            @foreach($desas as $d)
            <div class="card">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 truncate">{{ $d->name }}</h3>
                        @if($d->address)
                            <p class="text-sm text-gray-500 mt-0.5 line-clamp-2">{{ $d->address }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500 mb-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                        {{ $d->users_count }} Pengguna
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.desa.edit', $d->id) }}" class="flex-1 text-center text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 py-2 rounded-lg transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('admin.desa.destroy', $d->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus desa ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 py-2 rounded-lg transition-colors {{ $d->users_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if($d->users_count > 0) disabled @endif>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Desktop table -->
        <div class="hidden lg:block card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Nama Desa</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Alamat</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Jumlah Pengguna</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($desas as $d)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">{{ $d->name }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $d->address ?? '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $d->users_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.desa.edit', $d->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.desa.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus desa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors {{ $d->users_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                            @if($d->users_count > 0) disabled @endif title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
