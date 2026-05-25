@extends('layouts.app')

@section('title', 'Screening Kaki')
@section('page-title', 'Screening Kaki')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.foot-screening')])

    <!-- Info Card -->
    <div class="card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed">Jawablah pertanyaan berikut dengan jujur sesuai kondisi kaki Anda saat ini. Hasil screening ini bersifat informatif dan bukan pengganti diagnosis medis.</p>
        </div>
    </div>

    <!-- Survey Form -->
    <form id="screeningForm" action="{{ route('foot-screening.result') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="score" id="scoreInput" value="0">

        @php
            $questions = [
                'sensasi_terbakar'     => 'Sensasi terbakar, mati rasa, ataupun tajam pada kaki',
                'sensasi_sentuhan'     => 'Sensasi sentuhan pada telapak kaki menggunakan ujung pena/pensil (tampilkan telapak kaki dan titik sensasi)',
                'pulsasi_nyeri'        => 'Nyeri saat malam hari atau istirahat pada kaki kanan dan kiri (Sering kesentuhan nyeri kaki saat istirahat)',
                'pulsasi_kaki'         => 'Kaki terasa dingin',
                'pulsasi_pemeriksaan'  => 'Pemeriksaan nadi pada dorsalis pedis dan tibial posterior kaki kanan dan kaki kiri (Penurunan denyut nadi arteri dorsalis pedis, tibialis dan poplitea)',
                'bentuk_kulit'         => 'Kulit kering dan pecah-pecah',
                'bentuk_kapalan'       => 'Kapalan dan kuku kaki menebal',
                'bentuk_kaki'          => 'Bentuk kaki berubah (cantumkan bentuk kaki diabetes)',
            ];
        @endphp

        @foreach ($questions as $key => $text)
        @php $num = $loop->iteration; $color = $num <= 5 ? 'primary' : 'pink'; @endphp
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-{{ $color }}-500 to-{{ $color }}-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-{{ $color }}-500/20">{{ $num }}</div>
                <p class="text-gray-800 font-medium pt-0.5">{{ $text }} <span class="text-red-500">*</span></p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="{{ $key }}" value="YA" class="w-5 h-5 text-{{ $color }}-600 border-gray-300 focus:ring-{{ $color }}-500" required>
                    <span class="text-sm text-gray-700">YA</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="{{ $key }}" value="TIDAK" class="w-5 h-5 text-{{ $color }}-600 border-gray-300 focus:ring-{{ $color }}-500" required>
                    <span class="text-sm text-gray-700">TIDAK</span>
                </label>
            </div>
        </div>
        @endforeach

        <!-- Submit -->
        <div class="card text-center">
            <button type="submit" class="btn-primary inline-flex items-center gap-2 text-lg px-10 py-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Check
            </button>
            <p class="text-xs text-gray-400 mt-3">Pastikan semua pertanyaan telah dijawab sebelum melihat hasil</p>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('screeningForm').addEventListener('submit', function(e) {
    const keys = ['sensasi_terbakar','sensasi_sentuhan','pulsasi_nyeri','pulsasi_kaki','pulsasi_pemeriksaan','bentuk_kulit','bentuk_kapalan','bentuk_kaki'];
    let score = 0;
    let allAnswered = true;

    for (const key of keys) {
        const selected = this.querySelector('input[name="' + key + '"]:checked');
        if (!selected) {
            allAnswered = false;
            break;
        }
        if (selected.value === 'YA') {
            score++;
        }
    }

    if (!allAnswered) {
        e.preventDefault();
        alert('Harap jawab semua pertanyaan sebelum melihat hasil.');
        return false;
    }

    document.getElementById('scoreInput').value = score;
});
</script>
@endpush
