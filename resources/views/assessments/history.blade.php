@extends('layouts.app')

@section('title', 'Riwayat Assessment')
@section('page-title', 'Riwayat Assessment Kaki Diabetes')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Riwayat Penilaian</h2>
            <p class="text-sm text-gray-400 mt-0.5">Hasil assessment kaki diabetes Anda sebelumnya</p>
        </div>
        <a href="{{ route('assessment.index') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Penilaian Baru
        </a>
    </div>

    @if($results->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada riwayat penilaian</h3>
            <p class="text-sm text-gray-400 mb-6">Lakukan penilaian pertama Anda untuk melihat hasil di sini</p>
            <a href="{{ route('assessment.start') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Mulai Penilaian
            </a>
        </div>
    @else
        {{-- Mobile cards --}}
        <div class="lg:hidden space-y-4">
            @foreach($results as $result)
            <a href="{{ route('assessment.detail', $result->id) }}" class="card block hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm text-gray-400">{{ $result->created_at->format('d M Y, H:i') }}</span>
                    @php
                        $ruleCount = is_array($result->matched_rules) ? count($result->matched_rules) : 0;
                    @endphp
                    <span class="badge {{ $result->total_score > 6 ? 'badge-red' : ($result->total_score > 3 ? 'badge-yellow' : 'badge-green') }}">
                        {{ $result->total_score }} skor
                    </span>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span>{{ $ruleCount }} aturan cocok</span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Desktop table --}}
        <div class="hidden lg:block card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Tanggal</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Total Skor</th>
                            <th class="text-left px-6 py-4 text-sm font-semibold text-gray-500">Aturan Cocok</th>
                            <th class="text-right px-6 py-4 text-sm font-semibold text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($results as $result)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $result->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $result->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $result->total_score > 6 ? 'badge-red' : ($result->total_score > 3 ? 'badge-yellow' : 'badge-green') }}">
                                    {{ $result->total_score }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ is_array($result->matched_rules) ? count($result->matched_rules) : 0 }} aturan
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('assessment.detail', $result->id) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
