@extends('layouts.app')

@section('title', 'Riwayat Instrument')
@section('page-title', 'Riwayat Instrument Keyakinan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Riwayat</h2>
            <p class="text-sm text-gray-400 mt-0.5">{{ $results->count() }} kali pengisian</p>
        </div>
        <a href="{{ route('instruments.index') }}" class="btn-primary text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Isi Baru
        </a>
    </div>

    @if($results->isEmpty())
        <div class="card text-center py-16 text-gray-400">Belum ada riwayat.</div>
    @else
        <div class="space-y-4">
            @foreach($results as $r)
            @php
                $intColor = match($r->interpretation) {
                    'Keyakinan Tinggi' => 'border-l-green-500 bg-green-50/30',
                    'Keyakinan Sedang' => 'border-l-yellow-500 bg-yellow-50/30',
                    default => 'border-l-red-500 bg-red-50/30'
                };
            @endphp
            <a href="{{ route('instruments.result', $r->id) }}" class="card block border-l-4 {{ $intColor }} hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $r->interpretation }}</p>
                        <p class="text-xs text-gray-400">{{ $r->created_at->format('d M Y · H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-extrabold text-primary-600">{{ $r->percentage }}%</p>
                        <p class="text-xs text-gray-400">{{ $r->total_score }}/{{ $r->max_score }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
