@extends('layouts.app')

@section('title', 'Pilih Pasien')
@section('page-title', 'Pilih Pasien')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-primary-400 to-pink-500 flex items-center justify-center shadow-lg shadow-primary-200">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Pilih Pasien</h2>
            <p class="text-sm text-gray-400">{{ $pasienUsers->count() }} pasien ditemukan</p>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="card !p-3 sm:!p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 relative">
                @if($filterDesaId ?? false)<input type="hidden" name="desa_id" value="{{ $filterDesaId }}">@endif
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
                <input type="hidden" name="back" value="{{ $backUrl }}">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama pasien..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-300 focus:ring-4 focus:ring-primary-50 outline-none transition-all duration-200 text-sm">
            </form>
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
                <input type="hidden" name="back" value="{{ $backUrl }}">
                @if($q ?? false)<input type="hidden" name="q" value="{{ $q }}">@endif
                <select name="desa_id" onchange="this.form.submit()" class="px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-300 focus:ring-4 focus:ring-primary-50 outline-none transition-all duration-200 text-sm text-gray-600 cursor-pointer">
                    <option value="">Semua Desa</option>
                    @foreach($desas as $desa)
                        <option value="{{ $desa->id }}" {{ ($filterDesaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                    @endforeach
                </select>
                @if($filterDesaId ?? false)
                @php
                    $resetParams = ['redirect_to' => $redirectTo, 'back' => $backUrl];
                    if ($q ?? false) $resetParams['q'] = $q;
                @endphp
                <a href="{{ url()->current() }}?{{ http_build_query($resetParams) }}" class="inline-flex items-center gap-1.5 px-4 py-3 rounded-2xl bg-white border border-gray-200 text-gray-500 text-sm font-medium hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
                @endif
            </form>
            @endif
        </div>
    </div>

    {{-- Patient List --}}
    @if($pasienUsers->isEmpty())
        <div class="card text-center py-20 text-gray-400 rounded-3xl">
            <div class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            </div>
            <p class="font-semibold text-gray-500 text-base">Tidak ada pasien ditemukan</p>
            <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau kata kunci pencarian</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($pasienUsers as $p)
            <form method="POST" action="{{ route('admin.data-entry.select') }}" class="block">
                @csrf
                <input type="hidden" name="user_id" value="{{ $p->id }}">
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
                <button type="submit" class="w-full text-left p-4 rounded-2xl bg-white border border-gray-100 hover:border-primary-200 hover:bg-primary-50/30 hover:shadow-md transition-all duration-200 flex items-center gap-4 group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary-400 to-pink-500 flex items-center justify-center text-white font-bold shadow flex-shrink-0">
                        {{ strtoupper(substr($p->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-800 text-sm">{{ $p->name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($p->desa)
                            <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $p->desa->name }}
                            </span>
                            @endif
                            @if($p->address)
                            <span class="text-xs text-gray-300">·</span>
                            <span class="text-xs text-gray-400 truncate">{{ $p->address }}</span>
                            @endif
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-gray-300 group-hover:text-primary-400 group-hover:translate-x-1 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </form>
            @endforeach
        </div>
    @endif

    <div class="text-center pb-6">
        <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

</div>
@endsection
