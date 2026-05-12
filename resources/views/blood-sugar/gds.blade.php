@extends('layouts.app')

@section('title', 'Cek Gula Darah Sewaktu (GDS)')
@section('page-title', 'Cek Gula Darah Sewaktu (GDS)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Input Card -->
    <div class="card">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center shadow-lg shadow-pink-400/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Masukkan Kadar Gula Darah</h3>
                <p class="text-xs text-gray-400">Hasil pemeriksaan sewaktu (tanpa puasa)</p>
            </div>
        </div>

        <div class="mb-5">
            <label for="gdsValue" class="input-label">Kadar Gula Darah (mg/dL)</label>
            <input type="number" id="gdsValue" class="input-field text-lg" placeholder="Masukkan nilai gula darah, contoh: 150" min="0" max="999">
        </div>

        <button onclick="checkGDS()" class="btn-pink w-full">
            <svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cek Hasil
        </button>

        <!-- Result Area -->
        <div id="gdsResult" class="hidden mt-5 pt-5 border-t border-gray-100">
            <div id="gdsStatusBadge" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3"></div>
            <p id="gdsMessage" class="text-gray-700 font-medium"></p>
            <p id="gdsRecommendation" class="text-sm text-gray-500 mt-2 hidden"></p>
        </div>
    </div>

    <!-- Reference Card -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Referensi Rentang Gula Darah Sewaktu</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-sm font-medium text-green-800">Normal</span>
                </div>
                <span class="text-sm font-bold text-green-700">80 - 180 mg/dL</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm font-medium text-yellow-800">Tinggi</span>
                </div>
                <span class="text-sm font-bold text-yellow-700">&gt; 180 mg/dL</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-sm font-medium text-red-800">Sangat Tinggi</span>
                </div>
                <span class="text-sm font-bold text-red-700">&ge; 300 mg/dL</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-sm font-medium text-red-800">Beresiko</span>
                </div>
                <span class="text-sm font-bold text-red-700">70 - 79 mg/dL</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-100 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-red-600 rounded-full"></span>
                    <span class="text-sm font-medium text-red-800">Sangat Rendah</span>
                </div>
                <span class="text-sm font-bold text-red-700">&lt; 70 mg/dL</span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function checkGDS() {
    const value = parseInt(document.getElementById('gdsValue').value);
    const resultDiv = document.getElementById('gdsResult');
    const badge = document.getElementById('gdsStatusBadge');
    const message = document.getElementById('gdsMessage');
    const recommendation = document.getElementById('gdsRecommendation');

    if (isNaN(value) || value <= 0) {
        resultDiv.classList.remove('hidden');
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-gray-100 text-gray-600';
        badge.innerHTML = '&#9888;&#65039; Input Tidak Valid';
        message.textContent = 'Harap masukkan nilai gula darah yang valid.';
        recommendation.classList.add('hidden');
        return;
    }

    resultDiv.classList.remove('hidden');

    if (value >= 300) {
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Sangat Tinggi';
        message.textContent = 'Gula darah sangat tinggi, segera konsultasi ke dokter!';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong sangat tinggi (hiperglikemia berat). Segera hubungi dokter atau fasilitas kesehatan terdekat. Periksa kembali kadar gula darah Anda dan hindari makanan tinggi gula.';
    } else if (value > 180) {
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-yellow-100 text-yellow-700';
        badge.innerHTML = '&#9888;&#65039; Tinggi';
        message.textContent = 'Gula darah tinggi';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL berada di atas batas normal. Disarankan untuk memantau pola makan, mengurangi asupan karbohidrat sederhana, serta berkonsultasi dengan dokter jika hasil tetap tinggi.';
    } else if (value >= 80 && value <= 180) {
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-green-100 text-green-700';
        badge.innerHTML = '&#10004;&#65039; Normal';
        message.textContent = 'Gula darah normal';
        recommendation.classList.add('hidden');
    } else if (value >= 70) {
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Rendah';
        message.textContent = 'Gula darah rendah';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong rendah. Segera konsumsi makanan atau minuman manis seperti jus buah atau permen. Pantau gula darah kembali dalam 15 menit.';
    } else {
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Sangat Rendah';
        message.textContent = 'Gula darah sangat rendah, kondisi berbahaya!';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong hipoglikemia berat. Segera konsumsi glukosa cepat serap (gula, jus, atau glukosa tablet) dan cari bantuan medis darurat jika gejala tidak membaik.';
    }
}
</script>
@endpush
