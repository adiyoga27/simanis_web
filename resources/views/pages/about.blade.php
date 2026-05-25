@extends('layouts.guest')

@section('title', 'Tentang')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-10">
            <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Tentang SIMANIS</h1>
            <p class="text-gray-500 mt-2">Aplikasi Manajemen Diabetes Melitus</p>
        </div>

        <div class="space-y-6">
            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Apa itu SIMANIS?</h2>
                <p class="text-gray-600 leading-relaxed">
                    SIMANIS adalah aplikasi manajemen diri diabetes melitus yang dirancang untuk membantu 
                    penderita diabetes dalam mengelola kondisi kesehatan mereka secara mandiri. Aplikasi ini 
                    menyediakan berbagai fitur untuk memantau dan mengelola diabetes melitus secara komprehensif.
                </p>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Fitur Unggulan</h2>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>Screening Kaki Diabetik</strong> - Deteksi dini komplikasi kaki diabetik melalui survei mandiri.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>Pemantauan Gula Darah</strong> - Alat bantu interpretasi hasil pemeriksaan gula darah puasa dan sewaktu.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>Edukasi Diabetes</strong> - Artikel dan informasi seputar diabetes melitus dari sumber terpercaya.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>Terapi Nutrisi</strong> - Kalkulator BMI dan rekomendasi diet sesuai kebutuhan kalori harian.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span><strong>Farmakologi</strong> - Informasi jadwal dan jenis pengobatan diabetes.</span>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Visi & Misi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Meningkatkan kualitas hidup penderita diabetes melitus melalui manajemen diri yang 
                    terintegrasi dan mudah diakses. Kami percaya bahwa dengan pengelolaan yang tepat, 
                    setiap penderita diabetes dapat hidup sehat dan bahagia.
                </p>
                <p class="text-primary-600 font-semibold mt-3">#sehatkayabahagia</p>
            </div>

            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('login') }}" class="btn-white">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali
                </a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
