@extends('layouts.app')

@section('title', 'Tutorial Pemeriksaan Gula Darah')
@section('page-title', 'Tutorial Pemeriksaan Gula Darah')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Intro Card -->
    <div class="card">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-xl">Panduan Pemeriksaan Gula Darah</h3>
                <p class="text-gray-500 text-sm">Ikuti langkah-langkah berikut untuk hasil pemeriksaan yang akurat</p>
            </div>
        </div>
    </div>

    <!-- Step by Step -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-5">Langkah-langkah Pemeriksaan</h3>

        <div class="space-y-5">
            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">1</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Siapkan Alat</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Siapkan glukometer, strip tes, lancet (jarum), kapas alkohol, dan buku catatan. Pastikan alat dalam kondisi bersih dan strip tes belum kedaluwarsa.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">2</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Cuci Tangan</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Cuci tangan dengan sabun dan air hangat, lalu keringkan sepenuhnya. Tangan yang bersih memastikan hasil yang akurat dan mencegah infeksi.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">3</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Masukkan Strip Tes</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Masukkan strip tes ke dalam glukometer sesuai arah panah. Alat akan otomatis menyala dan siap digunakan.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">4</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Bersihkan Ujung Jari</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Bersihkan ujung jari (sisi samping, bukan tengah) dengan kapas alkohol. Biarkan mengering agar alkohol tidak mempengaruhi hasil.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">5</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Ambil Sampel Darah</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Gunakan lancet untuk menusuk sisi jari. Pijat lembut dari pangkal ke ujung jari untuk mengeluarkan tetesan darah. Jangan memencet terlalu keras.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">6</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Tempelkan Darah ke Strip</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Tempelkan tetesan darah ke ujung strip tes. Biarkan strip menyerap darah secara otomatis. Glukometer akan menghitung dan menampilkan hasil dalam beberapa detik.</p>
                </div>
            </div>

            <div class="flex gap-4">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/30">7</div>
                <div>
                    <h4 class="font-semibold text-gray-800">Catat Hasil</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Catat hasil pemeriksaan beserta tanggal dan waktu. Informasi ini sangat berguna untuk memantau perkembangan dan konsultasi dokter.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips Card -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Tips Penting</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="flex items-start gap-2 p-3 bg-primary-50 rounded-xl">
                <svg class="w-5 h-5 text-primary-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm text-gray-700">Untuk GDP: puasa minimal 8 jam, periksa di pagi hari</span>
            </div>
            <div class="flex items-start gap-2 p-3 bg-pink-50 rounded-xl">
                <svg class="w-5 h-5 text-pink-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm text-gray-700">Ganti lokasi tusukan jari secara bergantian setiap pemeriksaan</span>
            </div>
            <div class="flex items-start gap-2 p-3 bg-primary-50 rounded-xl">
                <svg class="w-5 h-5 text-primary-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                </svg>
                <span class="text-sm text-gray-700">Kalibrasi glukometer secara berkala sesuai petunjuk produsen</span>
            </div>
            <div class="flex items-start gap-2 p-3 bg-pink-50 rounded-xl">
                <svg class="w-5 h-5 text-pink-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span class="text-sm text-gray-700">Simpan strip tes di wadah asli, hindari panas dan kelembaban berlebih</span>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('blood-sugar') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pemantauan Gula Darah
        </a>
    </div>

</div>
@endsection
