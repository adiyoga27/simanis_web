@extends('layouts.app')

@section('title', 'Detail Hasil Screening')
@section('page-title', 'Detail Hasil Screening')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    @php
        $questions = [
            'sensasi_terbakar'     => 'Sensasi terbakar, mati rasa, ataupun tajam pada kaki',
            'sensasi_sentuhan'     => 'Sensasi sentuhan pada telapak kaki menggunakan ujung pena/pensil',
            'pulsasi_nyeri'        => 'Nyeri saat malam hari atau istirahat pada kaki kanan dan kiri',
            'pulsasi_kaki'         => 'Kaki terasa dingin',
            'pulsasi_pemeriksaan'  => 'Pemeriksaan nadi pada dorsalis pedis dan tibial posterior',
            'bentuk_kulit'         => 'Kulit kering dan pecah-pecah',
            'bentuk_kapalan'       => 'Kapalan dan kuku kaki menebal',
            'bentuk_kaki'          => 'Bentuk kaki berubah',
        ];
    @endphp

    <!-- Meta Info -->
    <div class="card">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h3 class="font-semibold text-gray-800 text-lg">Informasi Screening</h3>
                <p class="text-sm text-gray-400 mt-1">
                    {{ \Carbon\Carbon::parse($result->created_at)->isoFormat('dddd, D MMMM Y · HH:mm') }} WIB
                </p>
            </div>
            <span class="@if($result->risk_level === 'Risiko Tinggi') badge-red
                         @elseif($result->risk_level === 'Risiko Ringan') badge-yellow
                         @else badge-green @endif text-sm px-4 py-1.5">
                {{ $result->risk_level }}
            </span>
        </div>

        <div class="flex items-center gap-3">
            <div class="stat-card !p-4 flex-1 text-center">
                <span class="stat-value">{{ $result->score }}</span>
                <span class="stat-label">dari 8 gejala</span>
            </div>
            <div class="flex-1">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full transition-all duration-500 @if($result->risk_level === 'Risiko Tinggi') bg-red-500 @elseif($result->risk_level === 'Risiko Ringan') bg-yellow-500 @else bg-green-500 @endif" style="width: {{ ($result->score / 8) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Skor Risiko</p>
            </div>
        </div>
    </div>

    <!-- Answers Breakdown -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Rincian Jawaban</h3>
        <div class="space-y-2">
            @foreach ($questions as $key => $text)
                @php $num = $loop->iteration; $answer = ($result->answers[$key] ?? 'TIDAK') === 'YA'; @endphp
                <div class="flex items-center justify-between p-3 rounded-xl {{ $answer ? 'bg-red-50 border border-red-100' : 'bg-gray-50 border border-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg {{ $answer ? 'bg-red-100 text-red-600' : 'bg-gray-200 text-gray-500' }} flex items-center justify-center text-xs font-bold shrink-0">{{ $num }}</span>
                        <span class="text-sm text-gray-700">{{ $text }}</span>
                    </div>
                    <span class="text-sm font-semibold {{ $answer ? 'text-red-600' : 'text-green-600' }}">
                        {{ $result->answers[$key] ?? 'TIDAK' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Risk Level Detail -->
    @if ($result->risk_level === 'Risiko Tinggi')
        <div class="card border-2 border-red-200 bg-red-50/30">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-red-700">Risiko Tinggi</h4>
                    <p class="text-sm text-gray-600 mt-0.5">Segera konsultasikan dengan dokter spesialis untuk pemeriksaan lebih lanjut. Jaga kebersihan kaki, gunakan alas kaki yang tepat, dan periksa kaki setiap hari.</p>
                </div>
            </div>
        </div>
    @elseif ($result->risk_level === 'Risiko Ringan')
        <div class="card border-2 border-yellow-200 bg-yellow-50/30">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-yellow-700">Risiko Ringan</h4>
                    <p class="text-sm text-gray-600 mt-0.5">Terdapat beberapa gejala yang perlu diwaspadai. Lakukan pemeriksaan kaki mandiri setiap hari dan diskusikan hasil ini dengan dokter.</p>
                </div>
            </div>
        </div>
    @else
        <div class="card border-2 border-green-200 bg-green-50/30">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-green-700">Risiko Normal</h4>
                    <p class="text-sm text-gray-600 mt-0.5">Kondisi kaki Anda baik. Pertahankan perawatan rutin dan lakukan screening secara berkala.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <div class="text-center space-y-3 pb-6">
        <a href="{{ route('foot-screening.history') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            Kembali ke Riwayat
        </a>
        <br>
        <a href="{{ route('foot-screening.survey') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Ulangi Screening
        </a>
    </div>

</div>
@endsection
