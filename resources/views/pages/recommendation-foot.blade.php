@extends('layouts.app')

@section('title', 'Rekomendasi Perawatan Kaki')
@section('page-title', 'Rekomendasi Perawatan Kaki')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="card">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Rekomendasi Perawatan Kaki Diabetik</h2>
        <div class="prose max-w-none text-gray-600">
            <p>Perawatan kaki yang tepat sangat penting bagi penderita diabetes untuk mencegah komplikasi serius. Berikut adalah rekomendasi perawatan kaki diabetik:</p>
            
            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">1. Pemeriksaan Kaki Setiap Hari</h3>
            <p>Periksa kaki Anda setiap hari untuk melihat apakah ada luka, lecet, kemerahan, bengkak, atau masalah kuku. Gunakan cermin untuk memeriksa bagian bawah kaki jika diperlukan.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">2. Menjaga Kebersihan Kaki</h3>
            <p>Cuci kaki setiap hari dengan air hangat (bukan panas) dan sabun lembut. Keringkan dengan hati-hati, terutama di antara jari-jari kaki.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">3. Melembabkan Kulit</h3>
            <p>Gunakan pelembab pada bagian atas dan bawah kaki, tetapi hindari area di antara jari-jari kaki untuk mencegah infeksi jamur.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">4. Pemotongan Kuku yang Tepat</h3>
            <p>Potong kuku kaki secara lurus dan tidak terlalu pendek. Jangan memotong sudut kuku karena dapat menyebabkan kuku tumbuh ke dalam.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">5. Gunakan Alas Kaki yang Tepat</h3>
            <p>Selalu gunakan sepatu dan kaos kaki yang nyaman. Periksa bagian dalam sepatu sebelum memakainya untuk memastikan tidak ada benda asing.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">6. Hindari Berjalan Tanpa Alas Kaki</h3>
            <p>Jangan pernah berjalan tanpa alas kaki, bahkan di dalam rumah, untuk mencegah cedera yang tidak disadari.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">7. Kontrol Gula Darah</h3>
            <p>Menjaga kadar gula darah dalam rentang normal sangat penting untuk mencegah kerusakan saraf dan pembuluh darah di kaki.</p>

            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">8. Pemeriksaan Rutin ke Dokter</h3>
            <p>Lakukan pemeriksaan kaki secara rutin oleh tenaga medis profesional. Segera konsultasikan jika ditemukan masalah pada kaki.</p>
        </div>
    </div>

    <div class="card bg-gradient-to-r from-primary-50 to-pink-50 border-primary-100">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-primary-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <div>
                <h3 class="font-semibold text-gray-800">Peringatan!</h3>
                <p class="text-sm text-gray-600 mt-1">
                    Jika Anda menemukan luka yang tidak kunjung sembuh, perubahan warna kulit, 
                    atau tanda-tanda infeksi pada kaki, segera konsultasikan dengan dokter.
                </p>
            </div>
        </div>
    </div>

    <div class="flex justify-center gap-4">
        <a href="{{ route('foot-screening') }}" class="btn-white">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Screening
        </a>
        <a href="{{ route('foot-screening.survey') }}" class="btn-primary">Mulai Screening</a>
    </div>
</div>
@endsection
