@extends('layouts.app')

@section('title', 'Hasil Screening Kaki Diabetik')
@section('page-title', 'Hasil Screening Kaki Diabetik')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.foot-screening')])

    @php
        $score = $score ?? 0;
        $answers = $answers ?? [];
        $riskLevel = $score >= 3 ? 'Risiko Tinggi' : ($score >= 1 ? 'Risiko Ringan' : 'Normal');
    @endphp

    <!-- Risk Level Card -->
    @if ($score >= 3)
        <div class="card border-2 border-red-200 bg-red-50/30">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="badge-red text-base px-4 py-1.5 mb-3">{{ $riskLevel }}</div>
                <h3 class="text-xl font-bold text-red-700 mb-2">Segera konsultasikan dengan dokter!</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">Hasil screening menunjukkan risiko tinggi komplikasi kaki diabetik. Sangat disarankan untuk segera berkonsultasi dengan dokter spesialis untuk pemeriksaan lebih lanjut.</p>
                <div class="bg-white rounded-xl p-4 text-left space-y-2">
                    <h4 class="font-semibold text-red-700 text-sm">Rekomendasi:</h4>
                    <ul class="text-sm text-gray-600 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Segera buat janji dengan dokter spesialis kaki atau penyakit dalam
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Periksa kaki setiap hari untuk mendeteksi luka atau perubahan
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Gunakan alas kaki yang tepat dan nyaman setiap saat
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-red-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Jaga kebersihan kaki dan keringkan dengan baik setelah mencuci
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @elseif ($score >= 1)
        <div class="card border-2 border-yellow-200 bg-yellow-50/30">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="badge-yellow text-base px-4 py-1.5 mb-3">{{ $riskLevel }}</div>
                <h3 class="text-xl font-bold text-yellow-700 mb-2">Perlu Perhatian Khusus</h3>
                <p class="text-gray-600 text-sm leading-relaxed mb-4">Terdapat beberapa gejala yang perlu diwaspadai. Tingkatkan perawatan kaki dan pantau perkembangan kondisi Anda.</p>
                <div class="bg-white rounded-xl p-4 text-left space-y-2">
                    <h4 class="font-semibold text-yellow-700 text-sm">Rekomendasi:</h4>
                    <ul class="text-sm text-gray-600 space-y-1.5">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Lakukan pemeriksaan kaki mandiri setiap hari
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Gunakan pelembab untuk mencegah kulit kering dan pecah-pecah
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Hindari berjalan tanpa alas kaki untuk mencegah cedera
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            Diskusikan hasil ini dengan dokter pada kunjungan berikutnya
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <div class="card border-2 border-green-200 bg-green-50/30">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="badge-green text-base px-4 py-1.5 mb-3">{{ $riskLevel }}</div>
                <h3 class="text-xl font-bold text-green-700 mb-2">Kaki Anda dalam kondisi baik</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Kaki Anda dalam kondisi baik. Tetap jaga kesehatan kaki Anda dengan perawatan rutin dan pemeriksaan berkala.</p>
            </div>
        </div>
    @endif

    <!-- Score Summary -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Ringkasan Jawaban</h3>
        <div class="flex items-center gap-3 mb-5">
            <div class="stat-card !p-4 flex-1 text-center">
                <span class="stat-value">{{ $score }}</span>
                <span class="stat-label">dari 8 gejala</span>
            </div>
            <div class="flex-1">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full transition-all duration-500 @if($score >= 3) bg-red-500 @elseif($score >= 1) bg-yellow-500 @else bg-green-500 @endif" style="width: {{ ($score / 8) * 100 }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">Skor Risiko</p>
            </div>
        </div>

        <div class="space-y-2">
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

            @foreach ($questions as $key => $text)
                @php $num = $loop->iteration; $answer = ($answers[$key] ?? 'TIDAK') === 'YA'; @endphp
                <div class="flex items-center justify-between p-3 rounded-xl {{ $answer ? 'bg-red-50' : 'bg-gray-50' }}">
                    <span class="text-sm text-gray-700">{{ $num }}. {{ $text }}</span>
                    <span class="text-sm font-semibold {{ $answer ? 'text-red-600' : 'text-green-600' }}">
                        {{ $answers[$key] ?? 'TIDAK' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center space-y-3 pb-6">
        <a href="{{ route('foot-screening') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Dashboard
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
