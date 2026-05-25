@extends('layouts.app')

@section('title', 'Detail Hasil Instrument')
@section('page-title', 'Detail Hasil Instrument')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.instruments.results') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center text-lg font-bold text-gray-500">
                {{ strtoupper(substr($result->user?->name ?? 'U', 0, 1)) }}
            </div>
            <div>
                <p class="font-bold text-gray-800">{{ $result->user?->name ?? '-' }}</p>
                <p class="text-sm text-gray-400">{{ $result->user?->address ?? '-' }} · {{ $result->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-extrabold text-primary-600">{{ $result->total_score }}/{{ $result->max_score }}</p>
                <p class="text-xs text-gray-400 mt-1">Skor</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-extrabold text-primary-600">{{ $result->percentage }}%</p>
                <p class="text-xs text-gray-400 mt-1">Persentase</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 text-center flex items-center justify-center">
                @php
                    $intColor = match($result->interpretation) {
                        'Keyakinan Tinggi' => 'bg-green-100 text-green-700',
                        'Keyakinan Sedang' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-red-100 text-red-700'
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold {{ $intColor }}">{{ $result->interpretation }}</span>
            </div>
        </div>

        <h4 class="font-semibold text-gray-700 mb-3">Jawaban</h4>
        <div class="space-y-2">
            @foreach($result->answers as $a)
            <div class="py-2 border-b border-gray-50 last:border-0">
                <p class="text-xs text-gray-400">{{ $a['group_title'] ?? '' }}</p>
                <p class="text-sm text-gray-700">{{ $a['question'] ?? '' }}</p>
                <span class="text-xs font-semibold {{ ($a['answer'] ?? 0) == 3 ? 'text-green-600' : (($a['answer'] ?? 0) == 2 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $a['label'] ?? '-' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
