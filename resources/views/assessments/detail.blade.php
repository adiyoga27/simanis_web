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
            <a href="{{ route('admin.monitoring.assessments') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
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

                            @if(!empty($rule->result_text))
                            <div class="text-sm text-gray-800 leading-relaxed rounded-xl p-4 border" style="background-color: {{ $sc['light'] }}; border-color: {{ $sc['bg'] }}20; color: {{ $sc['text'] }}">
                                {!! nl2br(e($displayText)) !!}
                            </div>
                            @endif

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

    {{-- Conclusion --}}
    @if($result->conclusion)
    @php
        $concColor = $result->conclusion->color ?: match($result->conclusion->severity) {
            'normal' => '#16a34a', 'ringan' => '#ca8a04',
            'sedang' => '#ea580c', 'tinggi' => '#dc2626',
            default => '#6b7280'
        };
        $sevIcon = match($result->conclusion->severity) {
            'normal' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'ringan' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'sedang' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>',
        };
    @endphp
    <div class="relative mt-8">
        {{-- Section label --}}
        <div class="flex items-center gap-2 mb-4">
            <div class="h-px flex-1" style="background: linear-gradient(to right, {{ $concColor }}40, transparent)"></div>
            <span class="text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full" style="background-color: {{ $concColor }}15; color: {{ $concColor }}">Kesimpulan</span>
            <div class="h-px flex-1" style="background: linear-gradient(to left, {{ $concColor }}40, transparent)"></div>
        </div>

        {{-- Background glow --}}
        <div class="absolute -inset-1 rounded-3xl opacity-20 blur-xl" style="background: {{ $concColor }}"></div>

        {{-- Main card --}}
        <div class="relative overflow-hidden rounded-2xl border-2 shadow-lg" style="border-color: {{ $concColor }}40; background: linear-gradient(135deg, {{ $concColor }}08 0%, {{ $concColor }}12 100%)">
            {{-- Header --}}
            <div class="flex items-center gap-3 px-6 py-4 text-white" style="background: linear-gradient(135deg, {{ $concColor }}, {{ $concColor }}dd)">
                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $sevIcon !!}</svg>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-base leading-tight">{{ $result->conclusion->title }}</h3>
                    <p class="text-xs text-white/70 mt-0.5">Kesimpulan Hasil Pemeriksaan</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-white/20 backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                    {{ ucfirst($result->conclusion->severity) }}
                </span>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">
                @if($result->conclusion->description)
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $result->conclusion->description }}</p>
                @endif

                <div class="relative rounded-2xl p-5 backdrop-blur-xs" style="background-color: {{ $concColor }}0f; border: 1px solid {{ $concColor }}25">
                    {{-- Quote icon --}}
                    <div class="absolute -top-3 -left-1" style="color: {{ $concColor }}30">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    </div>
                    <p class="text-sm font-medium leading-relaxed" style="color: {{ $concColor }}dd">
                        {!! nl2br(e($result->conclusion->result_text)) !!}
                    </p>
                </div>

                @if($result->conclusion->reference_link)
                <div class="pt-3 border-t" style="border-color: {{ $concColor }}20">
                <a href="{{ $result->conclusion->reference_link }}" target="_blank" rel="noopener" class="group inline-flex items-center gap-3 w-full sm:w-auto px-5 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]" style="background: {{ $concColor }}; color: #fff; box-shadow: 0 4px 15px {{ $concColor }}40">
                    <svg class="w-5 h-5 group-hover:animate-bounce flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span>Lihat Rekomendasi Penanganan</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
