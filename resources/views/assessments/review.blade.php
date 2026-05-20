@extends('layouts.app')

@section('title', 'Hasil Assessment')
@section('page-title', 'Hasil Assessment Kaki Diabetes')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Ringkasan Skor --}}
    <div class="card">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Penilaian</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach($groups as $group)
                @php $gs = $groupScores[$group->id] ?? 0; @endphp
                <div class="bg-gray-50 rounded-xl p-4 text-center">
                    <p class="text-sm text-gray-500 mb-1">{{ $group->title }}</p>
                    <p class="text-3xl font-bold text-primary-600">{{ $gs }}</p>
                    <p class="text-xs text-gray-400">skor</p>
                </div>
            @endforeach
        </div>

        <div class="bg-gradient-to-r from-primary-50 to-pink-50 rounded-xl p-6 text-center">
            <p class="text-sm text-gray-500 mb-1">Total Skor</p>
            <p class="text-5xl font-extrabold text-primary-600">{{ $totalScore }}</p>
        </div>
    </div>

    {{-- Detail Pilihan --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Detail Pilihan Anda</h3>
        <div class="space-y-6">
            @foreach($groups as $group)
                @if(isset($selections[$group->id]))
                <div>
                    <h4 class="font-semibold text-gray-700 text-base mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-primary-500"></span>
                        {{ $group->title }}
                        <span class="badge badge-pink text-xs">Skor: {{ $groupScores[$group->id] ?? 0 }}</span>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-4">
                        @foreach($selections[$group->id] as $subGroupId => $selection)
                            @php $subGroup = \App\Models\AssessmentSubGroup::find($subGroupId); @endphp
                            <div class="bg-gray-50 rounded-xl p-3">
                                <p class="text-xs text-gray-400 mb-1">{{ $subGroup?->title ?? 'Sub #'.$subGroupId }}</p>
                                <div class="flex items-start gap-3">
                                    @if($selection['image'])
                                        <img src="{{ asset('storage/' . $selection['image']) }}" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @endif
                                    <div>
                                        <p class="text-sm text-gray-700">{{ $selection['text'] }}</p>
                                        <span class="text-xs text-primary-600 font-medium">Skor: +{{ $selection['score'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Hasil Aturan --}}
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Hasil Analisis</h3>

        @if(count($matchedRules) > 0)
            <div class="space-y-4">
                @foreach($matchedRules as $rule)
                    @php
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
                    @endphp
                    <div class="border-l-4 rounded-r-xl p-5 {{ $style }}">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="font-semibold text-gray-800">{{ $rule->title }}</h4>
                            <span class="{{ $badge }}">{{ ucfirst($rule->severity) }}</span>
                        </div>
                        @if($rule->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $rule->description }}</p>
                        @endif
                        <p class="text-sm text-gray-700">{{ $rule->result_text }}</p>
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
