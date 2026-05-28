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

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.assessments')])

    <div class="flex items-center gap-3">
        @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa', 'kader']))
            <a href="{{ route('admin.users.detail', $result->user_id) }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        @else
            <a href="{{ route('assessment.history') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        @endif
        <p class="text-xs text-gray-400">{{ $result->created_at->isoFormat('dddd, D MMMM Y · HH:mm') }}</p>
    </div>

    {{-- Score Summary --}}
    <div class="card text-center">
        @php
            $scorePercent = $result->total_score > 12 ? 100 : round(($result->total_score / 12) * 100);
            $scoreColor = $result->total_score > 6 ? 'red' : ($result->total_score > 3 ? 'yellow' : 'green');
            $scoreLabel = $result->total_score > 6 ? 'Risiko Tinggi' : ($result->total_score > 3 ? 'Risiko Sedang' : 'Risiko Rendah');
        @endphp
        <div class="text-xs text-gray-400 uppercase tracking-wider mb-2">Total Skor</div>
        <div class="text-5xl font-extrabold text-{{ $scoreColor }}-600 mb-2">{{ $result->total_score }}</div>
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-{{ $scoreColor }}-50 text-{{ $scoreColor }}-700">
            <span class="w-2 h-2 rounded-full bg-{{ $scoreColor }}-500"></span>
            {{ $scoreLabel }}
        </span>
        <div class="mt-4 w-full bg-gray-100 rounded-full h-2">
            <div class="h-2 rounded-full bg-{{ $scoreColor }}-500 transition-all" style="width: {{ $scorePercent }}%"></div>
        </div>
    </div>

    {{-- Pilihan Anda --}}
    @if(count($selections) > 0)
    <div>
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detail Pilihan</h3>
        <div class="space-y-4">
            @foreach($groups as $group)
                @if(isset($selections[$group->id]))
                @php $gScore = $result->group_scores[$group->id] ?? 0; @endphp
                <div class="card">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            @if($group->icon)
                                <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                                    {!! $group->icon !!}
                                </div>
                            @endif
                            <span class="font-semibold text-gray-800">{{ $group->title }}</span>
                        </div>
                        <span class="text-xs font-bold text-primary-600 bg-primary-50 px-2.5 py-1 rounded-full">{{ $gScore }} poin</span>
                    </div>
                    <div class="space-y-2">
                        @foreach($selections[$group->id] as $subGroupId => $selection)
                            <div class="flex items-center gap-3 p-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                                <div class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center shrink-0 overflow-hidden">
                                    @if($selection['image'])
                                        <img src="{{ asset('storage/' . $selection['image']) }}" alt="" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-700">{{ $selection['text'] }}</p>
                                </div>
                                <span class="text-xs font-semibold text-primary-500 bg-primary-50 px-2 py-0.5 rounded-full shrink-0">+{{ $selection['score'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- Kesimpulan --}}
    <div>
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
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

                        $severityColors = [
                            'normal' => ['bg' => '#16a34a', 'light' => '#f0fdf4', 'text' => '#166534'],
                            'ringan' => ['bg' => '#ca8a04', 'light' => '#fefce8', 'text' => '#854d0e'],
                            'sedang' => ['bg' => '#ea580c', 'light' => '#fff7ed', 'text' => '#9a3412'],
                            'tinggi' => ['bg' => '#dc2626', 'light' => '#fef2f2', 'text' => '#991b1b'],
                        ];
                        $severityIcons = [
                            'normal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                            'ringan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
                            'sedang' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
                            'tinggi' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
                        ];

                        $sc = $severityColors[$rule->severity] ?? $severityColors['normal'];
                        $iconPath = $severityIcons[$rule->severity] ?? $severityIcons['normal'];
                        $severityLabels = ['normal' => 'Normal','ringan' => 'Ringan','sedang' => 'Sedang','tinggi' => 'Tinggi'];
                        $sevLabel = $severityLabels[$rule->severity] ?? ucfirst($rule->severity);
                        $displayText = formatRuleTextDetail($rule->result_text, $aggregateResults ?? [], $rule->id);
                    @endphp
                    <div class="card overflow-hidden !p-0">
                        <div class="flex items-center gap-2 px-5 py-3 text-sm font-semibold text-white" style="background-color: {{ $customColor ?: $sc['bg'] }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $iconPath !!}</svg>
                            <span>{{ $rule->title }}</span>
                            <span class="ml-auto text-xs font-normal opacity-80">{{ $sevLabel }}</span>
                        </div>
                        <div class="px-5 py-4 space-y-3">
                            @if($rule->description)
                                <p class="text-sm text-gray-500 leading-relaxed">{{ $rule->description }}</p>
                            @endif

                            @if($rule->score_mode === 'aggregate' && isset($aggregateResults[$rule->id]))
                                <div class="inline-flex items-center gap-2 bg-primary-50 text-primary-700 text-xs font-semibold px-3 py-1.5 rounded-xl">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    Skor agregat: {{ $aggregateResults[$rule->id]['total'] }} · {{ implode(', ', $aggregateResults[$rule->id]['group_names']) }}
                                </div>
                            @endif

                            <div class="text-sm text-gray-800 leading-relaxed rounded-xl p-4 border" style="background-color: {{ $sc['light'] }}; border-color: {{ $sc['bg'] }}20; color: {{ $sc['text'] }}">
                                {!! nl2br(e($displayText)) !!}
                            </div>

                            @if(!empty($rule->reference_link))
                            <a href="{{ $rule->reference_link }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-medium text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-4 py-2.5 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                Rekomendasi Penanganan
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card text-center py-16">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">Tidak ada aturan yang cocok</p>
                <p class="text-sm text-gray-400 mt-1">Skor Anda tidak memicu aturan penilaian apapun.</p>
            </div>
        @endif
    </div>

</div>
@endsection
