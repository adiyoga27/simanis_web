@extends('layouts.app')

@section('title', 'Pemantauan Gula Darah')
@section('page-title', 'Pemantauan Gula Darah')

@section('content')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.glass-card {
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.55);
    box-shadow: 0 8px 32px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.03);
}
.bg-mesh-rose {
    background:
        radial-gradient(at 0% 0%, rgba(244,63,94,0.06) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(251,146,60,0.06) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(236,72,153,0.05) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(239,68,68,0.05) 0px, transparent 50%);
}
.stat-card {
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px -4px rgba(0,0,0,0.08);
}
.search-input {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
}
.search-input:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.08);
    outline: none;
}
.btn-gradient-rose {
    background: linear-gradient(135deg, #f43f5e 0%, #fb923c 100%);
    transition: all 0.3s ease;
}
.btn-gradient-rose:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(244, 63, 94, 0.35);
}
.btn-gradient-rose:active { transform: translateY(0); }

/* Table modern styles */
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
.value-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 56px;
    height: 32px;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 800;
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
    <div class="glass-card rounded-3xl p-6 sm:p-8 bg-mesh-rose">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-500 to-orange-500 flex items-center justify-center shadow-lg shadow-rose-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white" stroke="none">
                        <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                    </svg>
                </div>
                <div class="pt-0.5">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight">Pemantauan Gula Darah</h2>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-white/60 text-xs font-semibold text-gray-500 border border-gray-100/60">
                            {{ $results->total() }} catatan
                        </span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">GDP &amp; GDS real-time</span>
                    </p>
                </div>
            </div>
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
            <a href="{{ route('admin.data-entry.select-patient', ['redirect_to' => route('blood-sugar'), 'back' => url()->current()]) }}" class="btn-gradient-rose inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-6 py-3.5 shadow-lg shadow-rose-500/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Input Gula Darah
            </a>
            @endif
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        @php $statItems = [
            ['label'=>'Normal','key'=>'Normal','color'=>'green','from'=>'from-green-400','to'=>'to-emerald-500'],
            ['label'=>'Tinggi','key'=>'Tinggi','color'=>'yellow','from'=>'from-yellow-400','to'=>'to-amber-500'],
            ['label'=>'Rendah','key'=>'Rendah','color'=>'orange','from'=>'from-orange-400','to'=>'to-amber-500'],
            ['label'=>'Sangat Tinggi','key'=>'Sangat Tinggi','color'=>'red','from'=>'from-red-400','to'=>'to-rose-500'],
            ['label'=>'Sangat Rendah','key'=>'Sangat Rendah','color'=>'blue','from'=>'from-blue-400','to'=>'to-indigo-500'],
        ]; @endphp
        @foreach($statItems as $s)
        @php
            $statEmoji = match($s['key']) {
                'Normal' => '✅',
                'Tinggi' => '⚠️',
                'Rendah' => '⬇️',
                'Sangat Tinggi' => '🔴',
                'Sangat Rendah' => '🟢',
                default => '🟢',
            };
        @endphp
        <div class="stat-card glass-card rounded-2xl p-4 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $s['from'] }} {{ $s['to'] }}"></div>
            <div class="text-3xl mb-1">{!! $statEmoji !!}</div>
            <p class="text-2xl font-extrabold text-{{ $s['color'] }}-600 tabular-nums">{{ $stats[$s['key']] ?? 0 }}</p>
            <p class="text-[11px] font-semibold text-{{ $s['color'] }}-500/80 mt-0.5 uppercase tracking-wide">{{ $s['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Search & Filter --}}
    <div class="glass-card rounded-2xl p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex-1 relative">
                @if($desaId ?? false)<input type="hidden" name="desa_id" value="{{ $desaId }}">@endif
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama pasien..." class="search-input w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400">
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
            <div class="w-20 h-20 rounded-2xl bg-rose-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#fda4af" stroke="none"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
            </div>
            <p class="font-bold text-gray-600 text-lg">Belum ada data gula darah</p>
            <p class="text-sm text-gray-400 mt-2 max-w-xs mx-auto">Data pemeriksaan gula darah pasien akan muncul setelah dicatat melalui form input.</p>
        </div>
    @else
        {{-- Desktop Table --}}
        <div class="hidden md:block glass-card rounded-3xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Nilai</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($results as $index => $r)
                        @php
                            $catStyle = match($r->category) {
                                'Normal' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200/60', 'dot' => 'bg-green-500', 'badgeBg' => 'bg-green-100', 'badgeText' => 'text-green-700'],
                                'Tinggi' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200/60', 'dot' => 'bg-yellow-500', 'badgeBg' => 'bg-yellow-100', 'badgeText' => 'text-yellow-700'],
                                'Sangat Tinggi' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200/60', 'dot' => 'bg-red-500', 'badgeBg' => 'bg-red-100', 'badgeText' => 'text-red-700'],
                                'Rendah' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200/60', 'dot' => 'bg-orange-500', 'badgeBg' => 'bg-orange-100', 'badgeText' => 'text-orange-700'],
                                'Sangat Rendah' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200/60', 'dot' => 'bg-blue-500', 'badgeBg' => 'bg-blue-100', 'badgeText' => 'text-blue-700'],
                                default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200/60', 'dot' => 'bg-gray-400', 'badgeBg' => 'bg-gray-100', 'badgeText' => 'text-gray-600'],
                            };
                            $typeStyle = strtolower($r->type) === 'gdp'
                                ? ['bg' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60', 'label' => 'GDP', 'sub' => 'Puasa']
                                : ['bg' => 'bg-pink-50 text-pink-700 border-pink-200/60', 'label' => 'GDS', 'sub' => 'Sewaktu'];
                            $initial = strtoupper(substr($r->user?->name ?? 'U', 0, 1));
                            $name = $r->user?->name ?? 'Tidak Diketahui';
                        @endphp
                        <tr class="table-row-anim table-row-modern" style="animation-delay: {{ $index * 0.04 }}s">
                            {{-- Pasien --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $catStyle['badgeBg'] }} flex items-center justify-center text-xs font-extrabold {{ $catStyle['badgeText'] }} flex-shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">{{ $name }}</p>
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $r->user?->desa?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            {{-- Jenis --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold border {{ $typeStyle['bg'] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-50"></span>
                                    {{ $typeStyle['label'] }}
                                    <span class="font-normal opacity-60">· {{ $typeStyle['sub'] }}</span>
                                </span>
                            </td>
                            {{-- Nilai --}}
                            <td class="px-6 py-4 text-center">
                                <span class="value-badge {{ $catStyle['bg'] }} {{ $catStyle['text'] }} tabular-nums">
                                    {{ $r->value }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium ml-1">mg/dL</span>
                            </td>
                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold border {{ $catStyle['bg'] }} {{ $catStyle['text'] }} {{ $catStyle['border'] }}">
                                    <span class="w-2 h-2 rounded-full {{ $catStyle['dot'] }}"></span>
                                    {{ $r->category }}
                                </span>
                            </td>
                            {{-- Waktu --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 font-medium">
                                    {{ $r->recorded_at->format('d M Y') }}
                                </div>
                                <div class="text-[11px] text-gray-400 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $r->recorded_at->format('H:i') }}
                                </div>
                            </td>
                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
                                <form action="{{ route('admin.monitoring.blood-sugar.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus data ini secara permanen?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all duration-200 border border-transparent hover:border-red-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @else
                                <span class="text-xs text-gray-300">—</span>
                                @endif
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
                $catStyle = match($r->category) {
                    'Normal' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200/60', 'dot' => 'bg-green-500', 'badgeBg' => 'bg-green-100', 'badgeText' => 'text-green-700'],
                    'Tinggi' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200/60', 'dot' => 'bg-yellow-500', 'badgeBg' => 'bg-yellow-100', 'badgeText' => 'text-yellow-700'],
                    'Sangat Tinggi' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200/60', 'dot' => 'bg-red-500', 'badgeBg' => 'bg-red-100', 'badgeText' => 'text-red-700'],
                    'Rendah' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-700', 'border' => 'border-orange-200/60', 'dot' => 'bg-orange-500', 'badgeBg' => 'bg-orange-100', 'badgeText' => 'text-orange-700'],
                    'Sangat Rendah' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200/60', 'dot' => 'bg-blue-500', 'badgeBg' => 'bg-blue-100', 'badgeText' => 'text-blue-700'],
                    default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200/60', 'dot' => 'bg-gray-400', 'badgeBg' => 'bg-gray-100', 'badgeText' => 'text-gray-600'],
                };
                $typeStyle = strtolower($r->type) === 'gdp'
                    ? ['bg' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60', 'label' => 'GDP', 'sub' => 'Puasa']
                    : ['bg' => 'bg-pink-50 text-pink-700 border-pink-200/60', 'label' => 'GDS', 'sub' => 'Sewaktu'];
                $initial = strtoupper(substr($r->user?->name ?? 'U', 0, 1));
                $name = $r->user?->name ?? 'Tidak Diketahui';
            @endphp
            <div class="glass-card rounded-2xl p-4 table-row-anim" style="animation-delay: {{ $index * 0.04 }}s">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $catStyle['badgeBg'] }} flex items-center justify-center text-sm font-extrabold {{ $catStyle['badgeText'] }} flex-shrink-0">
                            {{ $initial }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-sm text-gray-800 truncate">{{ $name }}</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">{{ $r->user?->desa?->name ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold border {{ $typeStyle['bg'] }}">
                        {{ $typeStyle['label'] }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="value-badge {{ $catStyle['bg'] }} {{ $catStyle['text'] }}">{{ $r->value }}</span>
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg text-[11px] font-bold border {{ $catStyle['bg'] }} {{ $catStyle['text'] }} {{ $catStyle['border'] }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $catStyle['dot'] }}"></span>
                            {{ $r->category }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-gray-600">{{ $r->recorded_at->format('d M Y') }}</p>
                        <p class="text-[10px] text-gray-400">{{ $r->recorded_at->format('H:i') }}</p>
                    </div>
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