@extends('layouts.app')

@section('title', 'Detail Hasil Instrument')
@section('page-title', 'Detail Hasil Instrument')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.instruments.results') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <p class="text-xs text-gray-400">{{ $result->created_at->format('d M Y H:i') }}</p>
    </div>

    {{-- Score Summary --}}
    @php
        $intColor = match($result->interpretation) {
            'Keyakinan Tinggi' => 'green',
            'Keyakinan Sedang' => 'yellow',
            default => 'red'
        };
        $percentValue = $result->percentage;
    @endphp
    <div class="card text-center">
        <div class="text-xs text-gray-400 uppercase tracking-wider mb-2">Tingkat Keyakinan</div>
        <div class="text-5xl font-extrabold text-{{ $intColor }}-600 mb-2">{{ $result->percentage }}%</div>
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-semibold bg-{{ $intColor }}-50 text-{{ $intColor }}-700">
            <span class="w-2 h-2 rounded-full bg-{{ $intColor }}-500"></span>
            {{ $result->interpretation }}
        </span>
        <div class="mt-4 w-full bg-gray-100 rounded-full h-2.5">
            <div class="h-2.5 rounded-full bg-{{ $intColor }}-500 transition-all" style="width: {{ $percentValue }}%"></div>
        </div>
    </div>

    {{-- Info & Stats --}}
    <div class="card">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center text-white font-bold text-lg shrink-0">
                {{ strtoupper(substr($result->user?->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-gray-800">{{ $result->user?->name ?? '-' }}</p>
                <p class="text-sm text-gray-400">{{ $result->user?->address ?? '—' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Total Skor</p>
                <p class="text-2xl font-extrabold text-primary-600">{{ $result->total_score }}<span class="text-sm text-gray-400 font-normal">/{{ $result->max_score }}</span></p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-xs text-gray-400 mb-1">Jumlah Pertanyaan</p>
                <p class="text-2xl font-extrabold text-gray-700">{{ count($result->answers) }}</p>
            </div>
        </div>
    </div>

    {{-- Jawaban --}}
    @if(!empty($result->answers))
    @php
        $grouped = [];
        foreach ($result->answers as $a) {
            $groupTitle = $a['group_title'] ?? 'Lainnya';
            $grouped[$groupTitle][] = $a;
        }
    @endphp
    <div>
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detail Jawaban</h3>
        <div class="space-y-4">
            @foreach($grouped as $groupTitle => $items)
            <div class="card">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600 font-bold text-xs">
                        {{ $loop->iteration }}
                    </div>
                    <h4 class="font-semibold text-gray-800">{{ $groupTitle }}</h4>
                </div>
                <div class="space-y-3">
                    @foreach($items as $a)
                    <div class="flex items-start justify-between gap-4 py-2 border-b border-gray-50 last:border-0">
                        <p class="text-sm text-gray-600 flex-1">{{ $a['question'] ?? '' }}</p>
                        @php
                            $ans = $a['answer'] ?? 0;
                            $ansColor = $ans == 3 ? 'bg-green-100 text-green-700' : ($ans == 2 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-600');
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold shrink-0 {{ $ansColor }}">
                            {{ $a['label'] ?? '-' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
