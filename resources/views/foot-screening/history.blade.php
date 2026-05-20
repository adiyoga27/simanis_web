@extends('layouts.app')

@section('title', 'Riwayat Screening Kaki Diabetik')
@section('page-title', 'Riwayat Screening Kaki Diabetik')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <p class="text-gray-500 text-sm">
            @if($results->count() > 0)
                Menampilkan <strong class="text-primary-600">{{ $results->count() }}</strong> riwayat screening
            @else
                Belum ada riwayat screening
            @endif
        </p>
        <a href="{{ route('foot-screening.survey') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Screening Baru
        </a>
    </div>

    @if($results->count() > 0)
        <div class="card !p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="text-left px-5 py-3.5 font-semibold text-gray-600">Tanggal</th>
                            <th class="text-center px-5 py-3.5 font-semibold text-gray-600">Skor</th>
                            <th class="text-center px-5 py-3.5 font-semibold text-gray-600">Tingkat Risiko</th>
                            <th class="text-center px-5 py-3.5 font-semibold text-gray-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($results as $result)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-5 py-4">
                                    <p class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($result->created_at)->isoFormat('D MMMM Y') }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($result->created_at)->format('H:i') }} WIB</p>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-lg font-bold
                                        @if($result->risk_level === 'Risiko Tinggi') bg-red-50 text-red-600
                                        @elseif($result->risk_level === 'Risiko Ringan') bg-yellow-50 text-yellow-600
                                        @else bg-green-50 text-green-600 @endif">
                                        {{ $result->score }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="@if($result->risk_level === 'Risiko Tinggi') badge-red
                                                 @elseif($result->risk_level === 'Risiko Ringan') badge-yellow
                                                 @else badge-green @endif">
                                        {{ $result->risk_level }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <a href="{{ route('foot-screening.detail', $result->id) }}" class="inline-flex items-center gap-1.5 text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card text-center py-12">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Riwayat</h3>
            <p class="text-sm text-gray-500 mb-5">Anda belum pernah melakukan screening kaki diabetik.</p>
            <a href="{{ route('foot-screening.survey') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Mulai Screening Pertama
            </a>
        </div>
    @endif

    <div class="text-center pb-6">
        <a href="{{ route('foot-screening') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Halaman Screening
        </a>
    </div>

</div>
@endsection
