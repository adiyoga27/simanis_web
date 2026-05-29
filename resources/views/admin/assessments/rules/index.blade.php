@extends('layouts.app')

@section('title', 'Aturan & Kesimpulan')
@section('page-title', 'Aturan & Kesimpulan')

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
            <h2 class="text-xl font-bold text-gray-800">Aturan & Kesimpulan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola kategori, aturan penilaian, dan kesimpulan hasil</p>
        </div>
        <a href="{{ route('admin.assessments.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Kelompok
        </a>
    </div>

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.assessments.rules.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Aturan
            </a>
            <a href="{{ route('admin.assessments.conclusions.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Kesimpulan
            </a>
            <a href="{{ route('admin.assessments.categories.create') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Kategori
            </a>
        </div>
    </div>

    @if($categories->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada kategori aturan</h3>
            <p class="text-sm text-gray-400 mb-6">Buat kategori dulu untuk mengelompokkan aturan penilaian</p>
            <a href="{{ route('admin.assessments.categories.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </a>
        </div>
    @else
        @foreach($categories as $category)
        <div class="card overflow-hidden !p-0">
            <div class="flex items-center justify-between px-5 py-3 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center text-xs font-bold">{{ $category->order }}</span>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $category->title }}</h3>
                        @if($category->description)
                            <p class="text-xs text-gray-400">{{ $category->description }}</p>
                        @endif
                    </div>
                    <span class="text-xs text-gray-400">{{ $category->rules->count() }} aturan</span>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.assessments.categories.edit', $category->id) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit Kategori">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.assessments.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Aturan di dalamnya akan tetap ada (kategori jadi null).')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>

            @if($category->rules->isEmpty())
                <div class="px-5 py-8 text-center text-sm text-gray-400">
                    Belum ada aturan di kategori ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-50">
                            @foreach($category->rules as $rule)
                            @php
                                $sevColor = $rule->color ?: match($rule->severity) {
                                    'normal' => '#16a34a', 'ringan' => '#ca8a04',
                                    'sedang' => '#ea580c', 'tinggi' => '#dc2626',
                                    default => '#6b7280'
                                };
                                $sevLabel = ucfirst($rule->severity);
                            @endphp
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="pl-8 pr-3 py-3 w-8">
                                    <span class="text-gray-400 text-xs font-mono">{{ $rule->order }}</span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex items-center gap-2">
                                        <span class="font-medium text-gray-800">{{ $rule->title }}</span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $rule->score_mode === 'aggregate' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $rule->score_mode === 'aggregate' ? 'AGR' : 'AND' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-semibold border" style="background-color: {{ $sevColor }}15; color: {{ $sevColor }}; border-color: {{ $sevColor }}30">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $sevColor }}"></span>
                                        {{ $sevLabel }}
                                    </span>
                                </td>
                                <td class="px-3 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @if($rule->score_mode === 'aggregate')
                                            @foreach((array) ($rule->selected_groups ?? []) as $gId)
                                                @php $g = \App\Models\AssessmentGroup::find($gId); @endphp
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                    {{ $g?->title ?? '#' . $gId }}
                                                </span>
                                            @endforeach
                                            @if($rule->min_score !== null || $rule->max_score !== null)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-purple-50 text-purple-600 border border-purple-100">
                                                    @if($rule->min_score !== null && $rule->max_score !== null){{ $rule->min_score }}–{{ $rule->max_score }}
                                                    @elseif($rule->min_score !== null)&ge;{{ $rule->min_score }}
                                                    @else&le;{{ $rule->max_score }}@endif
                                                </span>
                                            @endif
                                        @else
                                            @foreach((array) ($rule->conditions ?? []) as $groupId => $minScore)
                                                @php $g = \App\Models\AssessmentGroup::find($groupId); @endphp
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                                    {{ $g?->title ?? '#' . $groupId }} &ge; {{ $minScore }}
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                                <td class="px-3 py-3 max-w-[200px]">
                                    <p class="text-xs text-gray-500 truncate">{{ $rule->description ?: Str::limit($rule->result_text, 60) }}</p>
                                </td>
                                <td class="px-3 py-3">
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
            @endif
        </div>
        @endforeach

        {{-- Uncategorized Rules --}}
        @if($uncategorizedRules->isNotEmpty())
        <div class="card overflow-hidden !p-0 border-2 border-dashed border-gray-300">
            <div class="flex items-center justify-between px-5 py-3 bg-amber-50 border-b border-amber-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">Belum Dikategorikan</h3>
                        <p class="text-xs text-gray-400">{{ $uncategorizedRules->count() }} aturan perlu dikategorikan</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($uncategorizedRules as $rule)
                        @php
                            $sevColor = $rule->color ?: match($rule->severity) {
                                'normal' => '#16a34a', 'ringan' => '#ca8a04',
                                'sedang' => '#ea580c', 'tinggi' => '#dc2626',
                                default => '#6b7280'
                            };
                            $sevLabel = ucfirst($rule->severity);
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="pl-8 pr-3 py-3 w-8">
                                <span class="text-gray-400 text-xs font-mono">{{ $rule->order }}</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="font-medium text-gray-800">{{ $rule->title }}</span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-semibold border" style="background-color: {{ $sevColor }}15; color: {{ $sevColor }}; border-color: {{ $sevColor }}30">
                                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $sevColor }}"></span>
                                    {{ $sevLabel }}
                                </span>
                            </td>
                            <td class="px-3 py-3 max-w-[200px]">
                                <p class="text-xs text-gray-500 truncate">{{ $rule->description ?: Str::limit($rule->result_text, 60) }}</p>
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.assessments.rules.edit', $rule->id) }}" class="px-2.5 py-1 rounded-lg text-xs font-medium text-amber-700 bg-amber-100 hover:bg-amber-200 transition-colors" title="Edit & pilih kategori">
                                        Atur Kategori
                                    </a>
                                    <form action="{{ route('admin.assessments.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')" class="inline">
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
    @endif

</div>
@endsection
