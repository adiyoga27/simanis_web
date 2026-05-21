@extends('layouts.app')

@section('title', 'Detail Screening Kaki')
@section('page-title', 'Detail Screening Kaki')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.monitoring.foot-screening') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Informasi</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-400">User</p>
                <p class="font-semibold text-gray-800">{{ $result->user?->name ?? '-' }}</p>
                <p class="text-xs text-gray-400">@{{ $result->user?->username ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal</p>
                <p class="font-semibold text-gray-800">{{ $result->created_at->format('d M Y · H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Skor</p>
                <p class="text-2xl font-extrabold text-primary-600">{{ $result->score }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Risiko</p>
                @php
                    $riskColor = match($result->risk_level) {
                        'Tinggi' => 'text-red-600 bg-red-50', 'Ringan' => 'text-yellow-600 bg-yellow-50',
                        default => 'text-green-600 bg-green-50'
                    };
                @endphp
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $riskColor }}">{{ $result->risk_level }}</span>
            </div>
        </div>

        @if($result->notes)
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-gray-400 mb-1">Catatan</p>
                <p class="text-sm text-gray-700">{{ $result->notes }}</p>
            </div>
        @endif
    </div>

    @if(!empty($result->answers))
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Jawaban</h3>
        <div class="space-y-2">
            @foreach($result->answers as $question => $answer)
            <div class="flex items-start justify-between py-2 border-b border-gray-50 last:border-0">
                <p class="text-sm text-gray-600">{{ $question }}</p>
                <span class="text-sm font-semibold text-gray-800 text-right ml-4">{{ is_array($answer) ? json_encode($answer) : $answer }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
