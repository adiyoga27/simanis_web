@extends('layouts.app')

@section('title', 'Monitoring Gula Darah')
@section('page-title', 'Monitoring Gula Darah')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Gula Darah</h2>
            <p class="text-sm text-gray-400 mt-0.5">{{ $results->total() }} catatan · semua pengguna</p>
        </div>
        <div class="flex items-center gap-3">
            @include('admin.partials.patient-selector', ['redirectTo' => route('blood-sugar'), 'dropdownId' => 'bloodSugarPatient'])
            <form method="GET">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari user..." class="input-field !w-48">
            </form>
        </div>
    </div>

    @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas']))
    <div class="card">@include('admin.partials.desa-filter')</div>
    @endif

    <div class="card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">User</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tipe</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Nilai</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Kategori</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($results as $r)
                    @php
                        $catColor = match($r->category) {
                            'Normal' => 'bg-green-100 text-green-700',
                            'Tinggi' => 'bg-yellow-100 text-yellow-700',
                            'Sangat Tinggi' => 'bg-red-100 text-red-700',
                            'Rendah' => 'bg-orange-100 text-orange-700',
                            'Sangat Rendah' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ strtoupper(substr($r->user?->name ?? 'U', 0, 1)) }}
                                </div>
                                <p class="font-medium text-gray-800">{{ $r->user?->name ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="badge {{ $r->type === 'GDP' ? 'bg-primary-100 text-primary-700' : 'bg-pink-100 text-pink-700' }} text-xs">{{ $r->type }}</span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-gray-800">{{ $r->value }} mg/dL</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $catColor }}">{{ $r->category }}</span>
                        </td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $r->recorded_at->format('d M Y · H:i') }}</td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            @if(Auth::user()->role !== 'kepala_puskesmas')
                            <form action="{{ route('admin.monitoring.blood-sugar.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 text-red-600 text-xs font-semibold hover:bg-red-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($results->isEmpty()) <div class="text-center py-12 text-gray-400 text-sm">Tidak ada data.</div> @endif
    </div>

    <div class="px-1">{{ $results->links() }}</div>

</div>
@endsection
