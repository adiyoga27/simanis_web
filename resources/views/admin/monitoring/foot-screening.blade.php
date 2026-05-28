@extends('layouts.app')

@section('title', 'Screening Kaki')
@section('page-title', 'Screening Kaki')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Screening Kaki</h2>
                <p class="text-sm text-gray-400">{{ $results->total() }} hasil · semua pengguna</p>
            </div>
        </div>
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
        <a href="{{ route('admin.data-entry.select-patient', ['redirect_to' => route('foot-screening.survey'), 'back' => url()->current()]) }}" class="btn-primary inline-flex items-center gap-2 text-sm !rounded-2xl !px-5 !py-3 shadow-lg shadow-amber-200 hover:shadow-xl hover:shadow-amber-300 transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Input Screening Kaki
        </a>
        @endif
    </div>

    {{-- Search & Filter Bar --}}
    <div class="card !p-3 sm:!p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 relative">
                @if($desaId ?? false)<input type="hidden" name="desa_id" value="{{ $desaId }}">@endif
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pasien..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-300 focus:ring-2 focus:ring-amber-100 outline-none transition-all duration-200 text-sm">
            </form>
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
            <form method="GET" class="flex items-center gap-2">
                @if($search ?? false)<input type="hidden" name="search" value="{{ $search }}">@endif
                <select name="desa_id" onchange="this.form.submit()" class="px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-300 focus:ring-2 focus:ring-amber-100 outline-none transition-all duration-200 text-sm text-gray-600 cursor-pointer">
                    <option value="">Semua Desa</option>
                    @foreach($desas as $desa)
                        <option value="{{ $desa->id }}" {{ ($desaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                    @endforeach
                </select>
                @if($desaId ?? false)
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except('desa_id', 'page')) }}" class="inline-flex items-center gap-1 px-4 py-3 rounded-2xl bg-white border border-gray-200 text-gray-500 text-sm font-medium hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
                @endif
            </form>
            @endif
        </div>
    </div>

    @if($results->isEmpty())
        <div class="card text-center py-16 text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
            <p class="font-medium">Belum ada data screening kaki.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($results as $r)
            @php
                $riskColor = match($r->risk_level) {
                    'Tinggi' => 'red', 'Ringan' => 'yellow',
                    default => 'green'
                };
                $riskBg = ['red' => 'bg-red-50 text-red-700', 'yellow' => 'bg-yellow-50 text-yellow-700', 'green' => 'bg-green-50 text-green-700'][$riskColor];
            @endphp
            <div class="card !p-5 hover:shadow-lg transition-shadow group">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-sm shadow flex-shrink-0">
                            {{ strtoupper(substr($r->user?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $r->user?->name ?? 'Tidak Diketahui' }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $r->created_at->format('d M Y · H:i') }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $riskBg }} flex-shrink-0">{{ $r->risk_level }}</span>
                </div>

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-2xl font-bold text-gray-800">{{ $r->score }}</span>
                        <span class="text-sm text-gray-400 ml-1">skor</span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.monitoring.foot-screening.detail', $r->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold hover:bg-amber-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Detail
                    </a>
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                    <form action="{{ route('admin.monitoring.foot-screening.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <div class="flex justify-center">{{ $results->links() }}</div>

</div>
@endsection
