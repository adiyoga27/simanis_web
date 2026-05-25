@extends('layouts.app')

@section('title', 'Detail Assessment')
@section('page-title', 'Hasil Assessment Kaki Diabetes')

@php
function formatRuleTextDetail($text, $aggregateResults, $ruleId) {
    $data = $aggregateResults[$ruleId] ?? null;
    if ($data) {
        $text = str_replace('{total}', $data['total'], $text);
        $text = str_replace('{groups}', implode(', ', $data['group_names']), $text);
    }
    return $text;
}
@endphp

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-400">{{ $result->created_at->isoFormat('dddd, D MMMM Y · HH:mm') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa', 'kader']))
                <a href="{{ route('admin.users.detail', $result->user_id) }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
            @else
                <a href="{{ route('assessment.history') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
            @endif
        </div>
    </div>

    {{-- Pilihan Anda --}}
    @if(count($selections) > 0)
    <div class="card">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Pilihan Anda</h3>
        <div class="space-y-4">
            @foreach($groups as $group)
                @if(isset($selections[$group->id]))
                @php $gScore = $result->group_scores[$group->id] ?? 0; @endphp
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-700">{{ $group->title }}</span>
                        <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">{{ $gScore }} poin</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($selections[$group->id] as $subGroupId => $selection)
                            <span class="inline-flex items-center gap-1 bg-gray-100 border border-gray-200 rounded-lg px-2.5 py-1.5 text-xs text-gray-700">
                                @if($selection['image'])
                                    <img src="{{ asset('storage/' . $selection['image']) }}" alt="" class="w-4 h-4 rounded object-cover">
                                @endif
                                <span>{{ $selection['text'] }}</span>
                                <span class="text-primary-500 font-medium ml-0.5">+{{ $selection['score'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <span class="text-sm font-medium text-gray-500">Total Skor</span>
            <span class="text-lg font-extrabold text-primary-600">{{ $result->total_score }}</span>
        </div>
    </div>
    @endif

    {{-- Kesimpulan --}}
    <div>
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">
            Kesimpulan
            @if($matchedRules->isNotEmpty())
                <span class="font-normal text-gray-400 normal-case tracking-normal ml-1">· {{ $matchedRules->count() }} aturan cocok</span>
            @endif
        </h3>

        @if($matchedRules->isNotEmpty())
            <div class="space-y-4">
                @foreach($matchedRules as $rule)
                    @php
                        $customColor = $rule->color ?? null;

                        $severityColors = ['normal' => '#16a34a','ringan' => '#ca8a04','sedang' => '#ea580c','tinggi' => '#dc2626'];
                        $severityIcons = [
                            'normal' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            'ringan' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                            'sedang' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                            'tinggi' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                        ];

                        $color = $customColor ?: ($severityColors[$rule->severity] ?? '#6b7280');
                        $icon = $severityIcons[$rule->severity] ?? $severityIcons['normal'];

                        $severityLabels = ['normal' => 'Normal','ringan' => 'Ringan','sedang' => 'Sedang','tinggi' => 'Tinggi'];
                        $sevLabel = $severityLabels[$rule->severity] ?? ucfirst($rule->severity);

                        $displayText = formatRuleTextDetail($rule->result_text, $aggregateResults ?? [], $rule->id);
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        {{-- Header bar --}}
                        <div class="flex items-center gap-2 px-5 py-3 text-white text-sm font-semibold" style="background-color: {{ $color }}">
                            {!! $icon !!}
                            <span>{{ $sevLabel }}</span>
                        </div>

                        {{-- Body --}}
                        <div class="px-5 py-4 space-y-3">
                            <h4 class="text-base font-bold text-gray-800">{{ $rule->title }}</h4>

                            @if($rule->description)
                                <p class="text-sm text-gray-500 leading-relaxed">{{ $rule->description }}</p>
                            @endif

                            @if($rule->score_mode === 'aggregate' && isset($aggregateResults[$rule->id]))
                                <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-700 text-xs font-semibold px-3 py-1.5 rounded-xl">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    Skor agregat: {{ $aggregateResults[$rule->id]['total'] }} · {{ implode(', ', $aggregateResults[$rule->id]['group_names']) }}
                                </div>
                            @endif

                            <div class="text-sm text-gray-800 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100">
                                {!! nl2br(e($displayText)) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center py-12">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500">Tidak ada aturan yang cocok dengan skor Anda.</p>
            </div>
        @endif
    </div>

</div>
@endsection
