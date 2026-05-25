@extends('layouts.app')

@section('title', 'Pemantauan Gula Darah')
@section('page-title', 'Pemantauan Gula Darah')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.blood-sugar')])

    <!-- Tutorial Card -->
    <a href="{{ route('blood-sugar.tutorial') }}" class="card-clickable flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800 text-lg">Tutorial Pemeriksaan Gula Darah</h3>
            <p class="text-sm text-gray-500 mt-0.5">Pelajari cara memeriksa gula darah dengan benar</p>
        </div>
        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

    <!-- Checker Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- GDP Card -->
        <a href="{{ route('blood-sugar.gdp') }}" class="card-clickable group">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg shadow-primary-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-xl">Gula Darah Puasa (GDP)</h3>
                    <p class="text-gray-500 mt-1.5 leading-relaxed">Cek kadar gula darah setelah puasa 8 jam. Ideal dilakukan di pagi hari sebelum sarapan.</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="badge-green text-xs">Puasa 8 Jam</span>
                <span class="text-xs text-gray-400">Rentang Normal: 80-130 mg/dL</span>
            </div>
        </a>

        <!-- GDS Card -->
        <a href="{{ route('blood-sugar.gds') }}" class="card-clickable group">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center shadow-lg shadow-pink-400/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-xl">Gula Darah Sewaktu (GDS)</h3>
                    <p class="text-gray-500 mt-1.5 leading-relaxed">Cek kadar gula darah tanpa puasa. Dapat dilakukan kapan saja sepanjang hari.</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="badge-green text-xs">Tanpa Puasa</span>
                <span class="text-xs text-gray-400">Rentang Normal: 80-180 mg/dL</span>
            </div>
        </a>
    </div>

    <!-- History Link -->
    <a href="{{ route('blood-sugar.history') }}" class="card-clickable flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-400/30 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-800 text-lg">Riwayat Pemeriksaan</h3>
            <p class="text-sm text-gray-500 mt-0.5">Lihat rekam jejak hasil pemeriksaan gula darah Anda</p>
        </div>
        <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

    <!-- Reference Card -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-3">Informasi Penting</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div class="flex items-start gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 mt-1.5 shrink-0"></div>
                <p class="text-gray-600">Pemeriksaan rutin membantu mengontrol kadar gula darah dan mencegah komplikasi.</p>
            </div>
            <div class="flex items-start gap-2">
                <div class="w-2 h-2 rounded-full bg-yellow-500 mt-1.5 shrink-0"></div>
                <p class="text-gray-600">Catat hasil pemeriksaan secara berkala untuk memantau perkembangan kondisi Anda.</p>
            </div>
            <div class="flex items-start gap-2">
                <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0"></div>
                <p class="text-gray-600">Segera konsultasi ke dokter jika hasil pemeriksaan di luar batas normal.</p>
            </div>
            <div class="flex items-start gap-2">
                <div class="w-2 h-2 rounded-full bg-primary-500 mt-1.5 shrink-0"></div>
                <p class="text-gray-600">Ikuti panduan dokter untuk jadwal dan frekuensi pemeriksaan yang sesuai.</p>
            </div>
        </div>
    </div>

</div>
@endsection
