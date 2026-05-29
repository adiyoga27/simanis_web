@extends('layouts.app')

@section('title', 'Kesimpulan')
@section('page-title', 'Kesimpulan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

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
            <h2 class="text-xl font-bold text-gray-800">Kesimpulan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kesimpulan muncul berdasarkan jumlah aturan yang cocok per kategori. Prioritas 0 = tertinggi.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.assessments.rules.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Aturan
            </a>
            <a href="{{ route('admin.assessments.conclusions.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kesimpulan
            </a>
        </div>
    </div>

    @if($conclusions->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-purple-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada kesimpulan</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan kesimpulan untuk menampilkan ringkasan hasil. Hanya 1 dengan prioritas tertinggi yang muncul.</p>
            <a href="{{ route('admin.assessments.conclusions.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kesimpulan Pertama
            </a>
        </div>
    @else
        <div class="card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider w-12">Prioritas</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Judul</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Kondisi (Kategori)</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tingkat</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Kesimpulan</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($conclusions as $conclusion)
                        @php
                            $sevColor = $conclusion->color ?: match($conclusion->severity) {
                                'normal' => '#16a34a', 'ringan' => '#ca8a04',
                                'sedang' => '#ea580c', 'tinggi' => '#dc2626',
                                default => '#6b7280'
                            };
                            $sevLabel = ucfirst($conclusion->severity);
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold {{ $conclusion->priority <= 1 ? 'bg-red-100 text-red-700' : ($conclusion->priority <= 3 ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-500') }}">
                                    {{ $conclusion->priority }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-semibold text-gray-800">{{ $conclusion->title }}</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $conclusion->match_logic === 'or' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }} ml-1.5">
                                    {{ strtoupper($conclusion->match_logic ?? 'and') }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($conclusion->conditions as $cond)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-primary-50 text-primary-600 border border-primary-100">
                                            {{ $cond->category?->title ?? '-' }}
                                            <span class="text-primary-400">&ge;{{ $cond->min_matched_rules }}</span>
                                            @if($cond->target_severity)
                                                @php
                                                    $cs = match($cond->target_severity) {
                                                        'normal' => '#16a34a','ringan' => '#ca8a04',
                                                        'sedang' => '#ea580c','tinggi' => '#dc2626',
                                                        default => '#6b7280'
                                                    };
                                                @endphp
                                                <span class="text-[10px]" style="color:{{ $cs }}">({{ ucfirst($cond->target_severity) }})</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold border" style="background-color: {{ $sevColor }}15; color: {{ $sevColor }}; border-color: {{ $sevColor }}30">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $sevColor }}"></span>
                                    {{ $sevLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-4 max-w-[200px]">
                                <p class="text-xs text-gray-500 truncate">{{ $conclusion->description ?: Str::limit($conclusion->result_text, 60) }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.assessments.conclusions.edit', $conclusion->id) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors opacity-0 group-hover:opacity-100" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.assessments.conclusions.destroy', $conclusion->id) }}" method="POST" onsubmit="return confirm('Hapus kesimpulan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors opacity-0 group-hover:opacity-100" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
