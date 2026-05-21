@extends('layouts.app')

@section('title', 'Hasil Assessment')
@section('page-title', 'Hasil Assessment Kaki Diabetes')

@php
function formatRuleText($text, $aggregateResults, $ruleId) {
    $data = $aggregateResults[$ruleId] ?? null;
    if ($data) {
        $text = str_replace('{total}', $data['total'], $text);
        $text = str_replace('{groups}', implode(', ', $data['group_names']), $text);
    }
    return $text;
}
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Pilihan Anda --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Pilihan Anda</h3>
        <div class="space-y-4">
            @foreach($groups as $group)
                @if(isset($selections[$group->id]))
                <div class="bg-gray-50 rounded-xl p-4">
                    <h4 class="font-medium text-gray-700 text-sm mb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                        {{ $group->title }}
                        <span class="badge badge-pink text-xs">Skor: {{ $groupScores[$group->id] ?? 0 }}</span>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach($selections[$group->id] as $subGroupId => $selection)
                            @php $subGroup = \App\Models\AssessmentSubGroup::find($subGroupId); @endphp
                            <div class="flex items-start gap-2 text-sm">
                                @if($selection['image'])
                                    <img src="{{ asset('storage/' . $selection['image']) }}" alt="" class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                                @endif
                                <div>
                                    <p class="text-gray-600">{{ $selection['text'] }}</p>
                                    <p class="text-xs text-gray-400">{{ $subGroup?->title ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Hasil Analisis --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Hasil Analisis</h3>

        @if(count($matchedRules) > 0)
            <div class="space-y-4">
                @foreach($matchedRules as $rule)
                    @php
                        $customColor = $rule->color ?? null;
                        if ($customColor) {
                            $borderStyle = "border-left-color: {$customColor};";
                            $bgStyle = "background: linear-gradient(to right, {$customColor}10, {$customColor}05);";
                            $badgeStyle = "background-color: {$customColor}20; color: {$customColor}; border: 1px solid {$customColor}40;";
                        } else {
                            $severityStyles = [
                                'normal' => 'border-l-green-500 bg-green-50/50',
                                'ringan' => 'border-l-yellow-500 bg-yellow-50/50',
                                'sedang' => 'border-l-orange-500 bg-orange-50/50',
                                'tinggi' => 'border-l-red-500 bg-red-50/50',
                            ];
                            $severityBadges = [
                                'normal' => 'badge-green',
                                'ringan' => 'badge-yellow',
                                'sedang' => 'bg-orange-100 text-orange-700 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold',
                                'tinggi' => 'badge-red',
                            ];
                            $style = $severityStyles[$rule->severity] ?? 'border-l-gray-300 bg-gray-50';
                            $badge = $severityBadges[$rule->severity] ?? 'badge';
                            $borderStyle = '';
                            $bgStyle = '';
                            $badgeStyle = '';
                        }

                        $displayText = formatRuleText($rule->result_text, $aggregateResults ?? [], $rule->id);
                    @endphp
                    <div class="border-l-4 rounded-r-xl p-5 {{ $customColor ? '' : $style }}" style="{{ $customColor ? $borderStyle . $bgStyle : '' }}">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            <h4 class="font-semibold text-gray-800">{{ $rule->title }}</h4>
                            @if($customColor)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="{{ $badgeStyle }}">{{ ucfirst($rule->severity) }}</span>
                            @else
                                <span class="{{ $badge }}">{{ ucfirst($rule->severity) }}</span>
                            @endif
                            @if($rule->score_mode === 'aggregate' && isset($aggregateResults[$rule->id]))
                                <span class="badge bg-indigo-50 text-indigo-600 text-xs">Total: {{ $aggregateResults[$rule->id]['total'] }}</span>
                            @endif
                        </div>
                        @if($rule->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $rule->description }}</p>
                        @endif
                        <p class="text-sm text-gray-700 leading-relaxed">{!! nl2br(e($displayText)) !!}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-gray-500">Tidak ada aturan yang cocok dengan skor Anda.</p>
            </div>
        @endif
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('assessment.index') }}" class="btn-white flex-1 text-center">Kembali ke Awal</a>
        <a href="{{ route('assessment.history') }}" class="btn-primary flex-1 text-center">Lihat Riwayat</a>
    </div>

</div>
@endsection
