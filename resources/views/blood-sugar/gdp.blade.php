@extends('layouts.app')

@section('title', 'Cek Gula Darah Puasa (GDP)')
@section('page-title', 'Cek Gula Darah Puasa (GDP)')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.blood-sugar')])

    <!-- Input Card -->
    <div class="card">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Masukkan Kadar Gula Darah</h3>
                <p class="text-xs text-gray-400">Hasil pemeriksaan setelah puasa 8 jam</p>
            </div>
        </div>

        <div class="mb-5">
            <label for="gdpValue" class="input-label">Kadar Gula Darah (mg/dL)</label>
            <input type="number" id="gdpValue" class="input-field text-lg" placeholder="Masukkan nilai gula darah, contoh: 110" min="0" max="999">
        </div>

        <button onclick="checkGDP()" class="btn-primary w-full">
            <svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cek Hasil
        </button>

        <!-- Result Area -->
        <div id="gdpResult" class="hidden mt-5 pt-5 border-t border-gray-100">
            <div id="gdpStatusBadge" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3"></div>
            <p id="gdpMessage" class="text-gray-700 font-medium"></p>
            <p id="gdpRecommendation" class="text-sm text-gray-500 mt-2 hidden"></p>

            <div id="gdpSaveArea" class="hidden mt-4 pt-4 border-t border-gray-100">
                <div class="mb-3">
                    <label for="gdpNotes" class="input-label">Catatan (opsional)</label>
                    <input type="text" id="gdpNotes" class="input-field" placeholder="Tambahkan catatan...">
                </div>
                <button onclick="saveGDP()" id="gdpSaveBtn" class="btn-primary w-full">
                    <svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Hasil
                </button>
                <p id="gdpSaveMessage" class="hidden text-sm font-medium mt-2 text-center"></p>
            </div>
        </div>
    </div>

    <!-- Reference Card -->
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Referensi Rentang Gula Darah Puasa</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-sm font-medium text-green-800">Normal</span>
                </div>
                <span class="text-sm font-bold text-green-700">80 - 130 mg/dL</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-xl">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                    <span class="text-sm font-medium text-yellow-800">Tinggi</span>
                </div>
                <span class="text-sm font-bold text-yellow-700">&gt; 130 mg/dL</span>
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
                    <span class="text-sm font-medium text-red-800">Rendah</span>
                </div>
                <span class="text-sm font-bold text-red-700">&lt; 80 mg/dL</span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let gdpCategory = '';
let gdpValue = 0;

function checkGDP() {
    const value = parseInt(document.getElementById('gdpValue').value);
    const resultDiv = document.getElementById('gdpResult');
    const badge = document.getElementById('gdpStatusBadge');
    const message = document.getElementById('gdpMessage');
    const recommendation = document.getElementById('gdpRecommendation');
    const saveArea = document.getElementById('gdpSaveArea');
    const saveMsg = document.getElementById('gdpSaveMessage');

    saveArea.classList.add('hidden');
    saveMsg.classList.add('hidden');

    if (isNaN(value) || value <= 0) {
        resultDiv.classList.remove('hidden');
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-gray-100 text-gray-600';
        badge.innerHTML = '&#9888;&#65039; Input Tidak Valid';
        message.textContent = 'Harap masukkan nilai gula darah yang valid.';
        recommendation.classList.add('hidden');
        return;
    }

    resultDiv.classList.remove('hidden');
    gdpValue = value;

    if (value >= 300) {
        gdpCategory = 'Sangat Tinggi';
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Sangat Tinggi';
        message.textContent = 'Gula darah sangat tinggi, segera konsultasi ke dokter!';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDP ' + value + ' mg/dL tergolong sangat tinggi (hiperglikemia berat). Segera hubungi dokter atau fasilitas kesehatan terdekat. Periksa kembali kadar gula darah Anda dan hindari makanan tinggi karbohidrat.';
    } else if (value > 130) {
        gdpCategory = 'Tinggi';
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-yellow-100 text-yellow-700';
        badge.innerHTML = '&#9888;&#65039; Tinggi';
        message.textContent = 'Gula darah tinggi';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDP ' + value + ' mg/dL berada di atas batas normal. Disarankan untuk memantau pola makan, mengurangi asupan gula dan karbohidrat sederhana, serta berkonsultasi dengan dokter jika hasil tetap tinggi dalam pemeriksaan berikutnya.';
    } else if (value >= 80) {
        gdpCategory = 'Normal';
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-green-100 text-green-700';
        badge.innerHTML = '&#10004;&#65039; Normal';
        message.textContent = 'Gula darah normal';
        recommendation.classList.add('hidden');
    } else {
        gdpCategory = 'Rendah';
        badge.className = 'inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-3 bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Rendah';
        message.textContent = 'Gula darah rendah';
        recommendation.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDP ' + value + ' mg/dL tergolong rendah (hipoglikemia). Segera konsumsi makanan atau minuman yang mengandung gula sederhana seperti jus buah, permen, atau glukosa tablet. Jika gejala berlanjut, segera cari bantuan medis.';
    }

    saveArea.classList.remove('hidden');
}

function saveGDP() {
    const btn = document.getElementById('gdpSaveBtn');
    const msg = document.getElementById('gdpSaveMessage');
    const notes = document.getElementById('gdpNotes').value;

    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 inline-block mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan...';

    fetch('{{ route('blood-sugar.save') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: 'GDP',
            value: gdpValue,
            category: gdpCategory,
            notes: notes
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            msg.className = 'text-sm font-medium mt-2 text-center text-green-600';
            msg.textContent = 'Hasil berhasil disimpan!';
            document.getElementById('gdpSaveArea').classList.add('hidden');
        } else {
            msg.className = 'text-sm font-medium mt-2 text-center text-red-600';
            msg.textContent = data.message || 'Gagal menyimpan. Coba lagi.';
        }
        msg.classList.remove('hidden');
    })
    .catch(() => {
        msg.className = 'text-sm font-medium mt-2 text-center text-red-600';
        msg.textContent = 'Terjadi kesalahan. Coba lagi.';
        msg.classList.remove('hidden');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Simpan Hasil';
    });
}
</script>
@endpush
