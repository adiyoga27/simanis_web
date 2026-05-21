@extends('layouts.app')

@section('title', 'Aturan Penilaian')
@section('page-title', 'Aturan Penilaian')

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
            <h2 class="text-xl font-bold text-gray-800">Aturan Penilaian</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola logika pencocokan skor dan hasil analisis</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.assessments.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Kelompok
            </a>
            <a href="{{ route('admin.assessments.rules.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Aturan
            </a>
        </div>
    </div>

    @if($rules->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada aturan penilaian</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan aturan untuk mencocokkan skor dengan hasil penilaian</p>
            <a href="{{ route('admin.assessments.rules.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Aturan Pertama
            </a>
        </div>
    @else
        <div class="card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider w-12">#</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Judul / Mode</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tingkat</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Kondisi / Rentang</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Deskripsi</th>
                            <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($rules as $rule)
                        @php
                            $sevColor = $rule->color ?: match($rule->severity) {
                                'normal' => '#16a34a', 'ringan' => '#ca8a04',
                                'sedang' => '#ea580c', 'tinggi' => '#dc2626',
                                default => '#6b7280'
                            };
                            $sevLabel = ucfirst($rule->severity);
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-5 py-4 text-gray-400 text-xs font-mono">{{ $rule->order }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">{{ $rule->title }}</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $rule->score_mode === 'aggregate' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $rule->score_mode === 'aggregate' ? 'AGR' : 'AND' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 ring-2 ring-offset-1" style="background-color: {{ $sevColor }}; --tw-ring-color: {{ $sevColor }}30"></span>
                                    <span class="text-gray-700 text-xs font-medium">{{ $sevLabel }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if($rule->score_mode === 'aggregate')
                                        @foreach((array) ($rule->selected_groups ?? []) as $gId)
                                            @php $g = \App\Models\AssessmentGroup::find($gId); @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                {{ $g?->title ?? '#' . $gId }}
                                            </span>
                                        @endforeach
                                        @if($rule->min_score !== null || $rule->max_score !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-purple-50 text-purple-600 border border-purple-100">
                                                @if($rule->min_score !== null && $rule->max_score !== null)
                                                    {{ $rule->min_score }}–{{ $rule->max_score }}
                                                @elseif($rule->min_score !== null)
                                                    &ge;{{ $rule->min_score }}
                                                @elseif($rule->max_score !== null)
                                                    &le;{{ $rule->max_score }}
                                                @endif
                                            </span>
                                        @endif
                                    @else
                                        @foreach((array) ($rule->conditions ?? []) as $groupId => $minScore)
                                            @php $g = \App\Models\AssessmentGroup::find($groupId); @endphp
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                {{ $g?->title ?? '#' . $groupId }}
                                                <span class="text-gray-400">&ge;</span>
                                                {{ $minScore }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-xs text-gray-500 max-w-[200px] truncate">{{ $rule->description ?: Str::limit($rule->result_text, 60) }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.assessments.rules.edit', $rule->id) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors opacity-0 group-hover:opacity-100" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.assessments.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')">
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
