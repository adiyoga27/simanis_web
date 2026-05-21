@extends('layouts.app')

@section('title', 'Hasil Instrument')
@section('page-title', 'Hasil Instrument Keyakinan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="card text-center">
        @php
            $intColor = match($result->interpretation) {
                'Keyakinan Tinggi' => 'text-green-600 bg-green-50',
                'Keyakinan Sedang' => 'text-yellow-600 bg-yellow-50',
                default => 'text-red-600 bg-red-50'
            };
            $intIcon = match($result->interpretation) {
                'Keyakinan Tinggi' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                'Keyakinan Sedang' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>',
                default => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
            };
        @endphp
        <div class="w-20 h-20 mx-auto rounded-full {{ $intColor }} flex items-center justify-center mb-4">
            {!! $intIcon !!}
        </div>
        <h2 class="text-2xl font-extrabold text-gray-800">{{ $result->interpretation }}</h2>
        <p class="text-gray-400 mt-1">Keyakinan Anda:</p>

        <div class="w-full bg-gray-100 rounded-full h-4 mt-4 overflow-hidden">
            <div class="h-full rounded-full transition-all duration-1000"
                style="width: {{ $result->percentage }}%; background-color: {{ $result->percentage >= 76 ? '#16a34a' : ($result->percentage >= 60 ? '#ca8a04' : '#dc2626') }}"></div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-6">
            <div>
                <p class="text-xs text-gray-400">Total Skor</p>
                <p class="text-xl font-extrabold text-primary-600">{{ $result->total_score }}/{{ $result->max_score }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Persentase</p>
                <p class="text-xl font-extrabold text-primary-600">{{ $result->percentage }}%</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal</p>
                <p class="text-sm font-semibold text-gray-700">{{ $result->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="font-semibold text-gray-800 mb-3">Detail Jawaban</h3>
        <div class="space-y-2">
            @php $lastGroup = ''; @endphp
            @foreach($result->answers as $a)
                @if(($a['group_title'] ?? '') !== $lastGroup)
                    @php $lastGroup = $a['group_title'] ?? ''; @endphp
                    <p class="text-xs font-semibold text-gray-400 uppercase pt-2">{{ $lastGroup }}</p>
                @endif
                <div class="flex items-center justify-between py-1.5 border-b border-gray-50 text-sm">
                    <span class="text-gray-600">{{ $a['question'] ?? '' }}</span>
                    <span class="font-semibold {{ ($a['answer'] ?? 0) == 3 ? 'text-green-600' : (($a['answer'] ?? 0) == 2 ? 'text-yellow-600' : 'text-red-600') }}">
                        {{ $a['label'] ?? '-' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('instruments.history') }}" class="btn-white flex-1 text-center">Riwayat</a>
        <a href="{{ route('instruments.index') }}" class="btn-primary flex-1 text-center">Isi Ulang</a>
    </div>

</div>
@endsection
