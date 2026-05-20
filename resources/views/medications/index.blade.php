@extends('layouts.app')

@section('title', 'Jadwal Obat')
@section('page-title', 'Jadwal Obat')

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

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Obat Anda</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola jadwal dan pengingat konsumsi obat diabetes</p>
        </div>
        <a href="{{ route('medications.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Obat
        </a>
    </div>

    @if($medications->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada jadwal obat</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan jadwal konsumsi obat Anda untuk mendapatkan pengingat</p>
            <a href="{{ route('medications.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Obat Pertama
            </a>
        </div>
    @else
        <!-- Mobile cards -->
        <div class="lg:hidden space-y-4">
            @foreach($medications as $med)
            <div class="card">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 truncate">{{ $med->title }}</h3>
                        @if($med->dosis)
                            <p class="text-sm text-pink-600 font-medium">{{ $med->dosis }}</p>
                        @endif
                    </div>
                    <span class="badge {{ $med->is_active ? 'badge-green' : 'badge-red' }} flex-shrink-0 ml-2">
                        {{ $med->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ \Carbon\Carbon::parse($med->date_at)->format('d M Y') }}
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $med->time_at }}
                    </div>
                    @if($med->duration)
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-6a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $med->duration }} mnt
                        </div>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('medications.edit', $med->id) }}" class="flex-1 text-center text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 py-2 rounded-lg transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('medications.destroy', $med->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus jadwal obat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full text-center text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 py-2 rounded-lg transition-colors">
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
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Nama Obat</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Dosis</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Tanggal</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Waktu</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Durasi</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Status</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($medications as $med)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800">{{ $med->title }}</p>
                                @if($med->description)
                                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $med->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($med->dosis)
                                    <span class="text-sm text-pink-600 font-medium">{{ $med->dosis }}</span>
                                @else
                                    <span class="text-sm text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($med->date_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $med->time_at }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $med->duration ? $med->duration . ' mnt' : '—' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $med->is_active ? 'badge-green' : 'badge-red' }}">
                                    {{ $med->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('medications.edit', $med->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('medications.destroy', $med->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
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
