@extends('layouts.app')

@section('title', 'Riwayat Instrumen Keyakinan')
@section('page-title', 'Riwayat Instrumen Keyakinan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-2xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-400 to-purple-500 flex items-center justify-center shadow-lg shadow-violet-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Riwayat Instrumen Keyakinan</h2>
                <p class="text-sm text-gray-400">{{ $results->total() }} hasil</p>
            </div>
        </div>
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
        <a href="{{ route('admin.data-entry.select-patient', ['redirect_to' => route('instruments.index'), 'back' => url()->current()]) }}" class="btn-primary inline-flex items-center gap-2 text-sm !rounded-2xl !px-5 !py-3 shadow-lg shadow-violet-200 hover:shadow-xl hover:shadow-violet-300 transition-all duration-300 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Input Instrumen
        </a>
        @endif
    </div>

    {{-- Search & Filter --}}
    <div class="card !p-3 sm:!p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 relative">
                @if($desaId ?? false)<input type="hidden" name="desa_id" value="{{ $desaId }}">@endif
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari pasien..." class="w-full pl-12 pr-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-300 focus:ring-4 focus:ring-violet-50 outline-none transition-all duration-200 text-sm">
            </form>
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
            <form method="GET" class="flex items-center gap-2">
                @if($search ?? false)<input type="hidden" name="search" value="{{ $search }}">@endif
                <select name="desa_id" onchange="this.form.submit()" class="px-4 py-3 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-violet-300 focus:ring-4 focus:ring-violet-50 outline-none transition-all duration-200 text-sm text-gray-600 cursor-pointer">
                    <option value="">Semua Desa</option>
                    @foreach($desas as $desa)
                        <option value="{{ $desa->id }}" {{ ($desaId ?? '') == $desa->id ? 'selected' : '' }}>{{ $desa->name }}</option>
                    @endforeach
                </select>
                @if($desaId ?? false)
                <a href="{{ url()->current() }}?{{ http_build_query(request()->except('desa_id', 'page')) }}" class="inline-flex items-center gap-1.5 px-4 py-3 rounded-2xl bg-white border border-gray-200 text-gray-500 text-sm font-medium hover:bg-gray-50 hover:text-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
                @endif
            </form>
            @endif
        </div>
    </div>

    @if($results->isEmpty())
        <div class="card text-center py-20 text-gray-400 rounded-3xl">
            <div class="w-20 h-20 rounded-full bg-violet-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-violet-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="font-semibold text-gray-500 text-base">Belum ada hasil instrumen</p>
            <p class="text-sm text-gray-400 mt-1">Data akan muncul setelah pasien mengisi instrumen keyakinan</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($results as $r)
            @php
                $intStyle = match($r->interpretation) {
                    'Keyakinan Tinggi' => ['bg' => 'from-green-400 to-emerald-500', 'badge' => 'bg-green-50 text-green-600 border-green-200', 'label' => 'Keyakinan Tinggi', 'shadow' => 'shadow-green-200'],
                    'Keyakinan Sedang' => ['bg' => 'from-yellow-400 to-amber-500', 'badge' => 'bg-yellow-50 text-yellow-600 border-yellow-200', 'label' => 'Keyakinan Sedang', 'shadow' => 'shadow-yellow-200'],
                    default => ['bg' => 'from-red-400 to-rose-500', 'badge' => 'bg-red-50 text-red-600 border-red-200', 'label' => 'Keyakinan Rendah', 'shadow' => 'shadow-red-200'],
                };
                $pct = $r->percentage ?? 0;
                $pctColor = $pct >= 70 ? 'bg-green-500' : ($pct >= 40 ? 'bg-yellow-500' : 'bg-red-500');
            @endphp
            <div class="card !p-0 overflow-hidden hover:shadow-xl transition-all duration-300 group rounded-3xl border-0 shadow-md">
                <div class="h-1.5 bg-gradient-to-r {{ $intStyle['bg'] }}"></div>
                <div class="p-5">
                    {{-- Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $intStyle['bg'] }} flex items-center justify-center text-white font-bold text-sm shadow {{ $intStyle['shadow'] }} flex-shrink-0">
                                {{ strtoupper(substr($r->user?->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-800 text-sm truncate">{{ $r->user?->name ?? 'Tidak Diketahui' }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $r->created_at->format('d M Y · H:i') }}
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $intStyle['badge'] }} flex-shrink-0">{{ $intStyle['label'] }}</span>
                    </div>

                    {{-- Score Section --}}
                    <div class="bg-gray-50 rounded-2xl p-4 mb-4">
                        <div class="flex items-end justify-between mb-3">
                            <div>
                                <p class="text-3xl font-extrabold text-gray-800 tracking-tight">{{ $r->total_score }}<span class="text-lg text-gray-300">/{{ $r->max_score }}</span></p>
                                <p class="text-xs text-gray-400 mt-0.5 font-medium">Total Skor</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold {{ $pct >= 70 ? 'text-green-600' : ($pct >= 40 ? 'text-yellow-600' : 'text-red-600') }}">{{ $pct }}%</p>
                                <p class="text-xs text-gray-400 font-medium">Persentase</p>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="h-2 rounded-full {{ $pctColor }} transition-all duration-500" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.instruments.results.detail', $r->id) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl bg-violet-50 text-violet-700 text-xs font-semibold hover:bg-violet-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </a>
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                        <form action="{{ route('admin.instruments.results.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    <div class="flex justify-center">{{ $results->links() }}</div>

</div>
@endsection
