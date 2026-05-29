@extends('layouts.app')

@section('title', 'Farmakologi')
@section('page-title', 'Farmakologi')

@section('content')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.glass-card {
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.55);
    box-shadow: 0 8px 32px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.03);
}
.bg-mesh-teal {
    background:
        radial-gradient(at 0% 0%, rgba(20,184,166,0.07) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(6,182,212,0.07) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(59,130,246,0.05) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(16,185,129,0.05) 0px, transparent 50%);
}
.search-input {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
}
.search-input:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.08);
    outline: none;
}
.select-modern {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.2em 1.2em;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.select-modern:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.08);
    outline: none;
}
.btn-gradient-teal {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    transition: all 0.3s ease;
}
.btn-gradient-teal:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(20, 184, 166, 0.35);
}
.btn-export {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    transition: all 0.3s ease;
}
.btn-export:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.35);
}
.table-row-anim {
    animation: fadeInUp 0.35s ease-out forwards;
    opacity: 0;
}
.table-row-modern {
    transition: background-color 0.2s ease, transform 0.15s ease;
}
.table-row-modern:hover {
    background-color: rgba(249, 250, 251, 0.8);
}
</style>

<div class="max-w-7xl mx-auto space-y-6 pb-8">

    @if(session('success'))
        <div class="glass-card rounded-2xl p-4 flex items-center gap-3 text-green-700 text-sm border border-green-200/60" style="animation: fadeIn 0.4s ease-out">
            <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Hero Header --}}
    <div class="glass-card rounded-3xl p-6 sm:p-8 bg-mesh-teal">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-teal-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.5 20.5l10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/>
                        <path d="M8.5 8.5l7 7"/>
                    </svg>
                </div>
                <div class="pt-0.5">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight">Farmakologi</h2>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-white/60 text-xs font-semibold text-gray-500 border border-gray-100/60">
                            {{ $results->total() }} catatan
                        </span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">Data obat pasien</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pharmacology.export') }}?{{ http_build_query(request()->except('page')) }}" class="btn-export inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-5 py-3.5 shadow-lg shadow-emerald-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export
                </a>
                @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                <a href="{{ route('admin.data-entry.select-patient', ['redirect_to' => route('admin.pharmacology.create'), 'back' => url()->current()]) }}" class="btn-gradient-teal inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-6 py-3.5 shadow-lg shadow-teal-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Input Farmakologi
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="glass-card rounded-2xl p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 relative">
                @if($desaId ?? false)<input type="hidden" name="desa_id" value="{{ $desaId }}">@endif
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pasien atau obat..." class="search-input w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400">
            </form>
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
            <div class="flex items-center gap-2">
                @if($search ?? false)<input type="hidden" name="search" value="{{ $search }}" form="filterDesaForm">@endif
                <form method="GET" id="filterDesaForm" class="flex items-center gap-2">
                    <div class="flex items-center gap-2 px-4 py-3.5 rounded-2xl border-2 border-gray-200 bg-white/70">
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <select name="desa_id" onchange="this.form.submit()" class="bg-transparent border-0 outline-none text-sm font-medium text-gray-600 cursor-pointer min-w-[140px]">
                            <option value="">Semua Desa</option>
                            @foreach($desas as $desa)
                                <option value="{{ $desa->id }}" {{ ($desaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                @if($desaId ?? false)
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except('desa_id', 'page')) }}" class="inline-flex items-center justify-center w-11 h-11 rounded-2xl bg-white border-2 border-gray-200 text-gray-400 hover:bg-gray-50 hover:text-gray-600 hover:border-gray-300 transition-all duration-200 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if($results->isEmpty())
        <div class="glass-card text-center py-20 text-gray-400 rounded-3xl">
            <div class="w-20 h-20 rounded-2xl bg-teal-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#99f6e4" stroke="none">
                    <path d="M10.5 20.5l10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/>
                    <path d="M8.5 8.5l7 7"/>
                </svg>
            </div>
            <p class="font-bold text-gray-600 text-lg">Belum ada data farmakologi</p>
            <p class="text-sm text-gray-400 mt-2 max-w-xs mx-auto">Data obat pasien akan muncul setelah dicatat melalui form input.</p>
        </div>
    @else
        {{-- Desktop Table --}}
        <div class="hidden md:block glass-card rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Judul Obat</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Dosis</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Mulai Minum</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($results as $index => $r)
                        @php
                            $initial = strtoupper(substr($r->user?->name ?? 'U', 0, 1));
                            $name = $r->user?->name ?? 'Tidak Diketahui';
                        @endphp
                        <tr class="table-row-anim table-row-modern" style="animation-delay: {{ $index * 0.04 }}s">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center text-xs font-extrabold text-teal-700 flex-shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $name }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $r->user?->desa?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-sm text-gray-800">{{ $r->medication_title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-cyan-50 text-cyan-700 border border-cyan-100/60">
                                    {{ $r->daily_dose }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 font-medium">
                                    {{ $r->start_date?->format('d M Y') ?? '-' }}
                                </div>
                                <div class="text-[11px] text-gray-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $r->start_time?->format('H:i') ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-500 max-w-[200px] truncate" title="{{ $r->description }}">{{ $r->description ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.pharmacology.edit', $r->id) }}" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-teal-50 text-teal-700 text-xs font-semibold hover:bg-teal-100 transition-colors border border-teal-100/60">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                                    <form action="{{ route('admin.pharmacology.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200 border border-transparent hover:border-red-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile List --}}
        <div class="md:hidden space-y-3">
            @foreach($results as $index => $r)
            @php
                $initial = strtoupper(substr($r->user?->name ?? 'U', 0, 1));
                $name = $r->user?->name ?? 'Tidak Diketahui';
            @endphp
            <div class="glass-card rounded-2xl p-4 table-row-anim" style="animation-delay: {{ $index * 0.04 }}s">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center text-sm font-extrabold text-teal-700 flex-shrink-0">
                            {{ $initial }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-sm text-gray-800 truncate">{{ $name }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $r->user?->desa?->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <p class="font-semibold text-sm text-gray-800">{{ $r->medication_title }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $r->description ?? '-' }}</p>
                </div>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-bold bg-cyan-50 text-cyan-700 border border-cyan-100/60">
                        {{ $r->daily_dose }}
                    </span>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-gray-600">{{ $r->start_date?->format('d M Y') ?? '-' }}</p>
                        <p class="text-[10px] text-gray-400">{{ $r->start_time?->format('H:i') ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 pt-3 mt-3 border-t border-gray-100">
                    <a href="{{ route('admin.pharmacology.edit', $r->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-teal-50 text-teal-700 text-xs font-semibold hover:bg-teal-100 transition-colors border border-teal-100/60">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit
                    </a>
                    @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                    <form action="{{ route('admin.pharmacology.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200 border border-transparent hover:border-red-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- Pagination --}}
    @if($results->hasPages())
    <div class="flex justify-center pt-2">
        {{ $results->links() }}
    </div>
    @endif

</div>
@endsection