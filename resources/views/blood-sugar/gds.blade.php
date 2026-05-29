@extends('layouts.app')

@section('title', 'Cek Gula Darah Sewaktu (GDS)')
@section('page-title', 'Cek Gula Darah Sewaktu (GDS)')

@section('content')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes pulse-soft {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
@keyframes slideIn {
    from { opacity: 0; transform: translateX(-10px); }
    to { opacity: 1; transform: translateX(0); }
}
.glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.5);
    box-shadow: 0 8px 32px rgba(0,0,0,0.06), 0 2px 8px rgba(0,0,0,0.04);
}
.gauge-container {
    position: relative;
    height: 12px;
    border-radius: 999px;
    background: linear-gradient(90deg, #ef4444 0%, #f59e0b 15%, #22c55e 30%, #22c55e 55%, #f59e0b 75%, #ef4444 100%);
    overflow: visible;
}
.gauge-marker {
    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    background: white;
    border: 3px solid currentColor;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    transition: left 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    z-index: 10;
}
.gauge-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    font-size: 0.7rem;
    color: #9ca3af;
}
.result-appear {
    animation: fadeInUp 0.5s ease-out forwards;
}
.status-card {
    transition: all 0.3s ease;
}
.status-card:hover {
    transform: translateY(-2px);
}
.input-modern {
    transition: all 0.2s ease;
    border: 2px solid #e5e7eb;
}
.input-modern:focus {
    border-color: #ec4899;
    box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
    outline: none;
}
.btn-gradient-pink {
    background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.btn-gradient-pink:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.4);
}
.btn-gradient-pink:active {
    transform: translateY(0);
}
.bg-mesh-pink {
    background:
        radial-gradient(at 0% 0%, rgba(236,72,153,0.08) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(244,63,94,0.08) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(251,146,60,0.06) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(244,114,182,0.06) 0px, transparent 50%);
}
</style>

<div class="max-w-2xl mx-auto space-y-6 pb-8">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.blood-sugar')])

    <!-- Hero / Input Section -->
    <div class="glass-card rounded-3xl p-6 sm:p-8 bg-mesh-pink">
        <div class="flex items-start gap-4 mb-6">
            <div class="shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center shadow-lg shadow-pink-500/25">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="pt-0.5">
                <h2 class="text-lg font-bold text-gray-900 leading-tight">Gula Darah Sewaktu (GDS)</h2>
                <p class="text-sm text-gray-500 mt-0.5">Masukkan hasil pemeriksaan sewaktu (tanpa puasa)</p>
            </div>
        </div>

        <div class="mb-6">
            <label for="gdsValue" class="block text-sm font-semibold text-gray-700 mb-2">Kadar Gula Darah</label>
            <div class="relative">
                <input type="number" id="gdsValue" class="input-modern w-full rounded-2xl px-5 py-4 text-2xl font-bold text-gray-800 placeholder-gray-300 bg-white/70" placeholder="0" min="0" max="999">
                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-sm font-medium text-gray-400">mg/dL</span>
            </div>
        </div>

        <button onclick="checkGDS()" class="btn-gradient-pink w-full rounded-2xl py-4 text-white font-semibold shadow-lg shadow-pink-500/25 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Cek Hasil
        </button>

        <!-- Result Area -->
        <div id="gdsResult" class="hidden mt-6 pt-6 border-t border-gray-100/60">

            <!-- Status Header -->
            <div id="gdsStatusHeader" class="flex items-center gap-3 mb-5 result-appear" style="animation-delay:0.05s">
                <div id="gdsStatusIcon" class="w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md"></div>
                <div>
                    <div id="gdsStatusBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider"></div>
                    <p id="gdsMessage" class="text-gray-800 font-semibold text-base mt-0.5"></p>
                </div>
            </div>

            <!-- Gauge -->
            <div class="mb-5 result-appear" style="animation-delay:0.1s">
                <div class="flex justify-between items-end mb-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Posisi pada Skala</span>
                    <span id="gaugeValue" class="text-sm font-bold text-gray-800">—</span>
                </div>
                <div class="gauge-container">
                    <div id="gaugeMarker" class="gauge-marker text-pink-500" style="left:0%; color:#ec4899;"></div>
                </div>
                <div class="gauge-labels">
                    <span>0</span>
                    <span>70</span>
                    <span>80</span>
                    <span>180</span>
                    <span>300+</span>
                </div>
            </div>

            <!-- Recommendation -->
            <div id="gdsRecommendationBox" class="hidden result-appear" style="animation-delay:0.15s">
                <div class="rounded-2xl p-5 bg-gradient-to-r from-gray-50 to-gray-100/50 border border-gray-100">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 w-8 h-8 rounded-xl bg-white flex items-center justify-center shadow-sm">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800 mb-1">Rekomendasi</h4>
                            <p id="gdsRecommendation" class="text-sm text-gray-600 leading-relaxed"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Area -->
            <div id="gdsSaveArea" class="hidden mt-5 result-appear" style="animation-delay:0.2s">
                <div class="rounded-2xl p-5 bg-white/60 border border-gray-100/80">
                    <label for="gdsNotes" class="block text-sm font-semibold text-gray-700 mb-2">Catatan (opsional)</label>
                    <input type="text" id="gdsNotes" class="input-modern w-full rounded-xl px-4 py-3 text-sm bg-white/70 mb-4" placeholder="Tambahkan catatan...">
                    <button onclick="saveGDS()" id="gdsSaveBtn" class="btn-gradient-pink w-full rounded-xl py-3.5 text-white font-semibold shadow-lg shadow-pink-500/25 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Simpan Hasil
                    </button>
                </div>
            </div>

            <!-- Save Message -->
            <div id="gdsSaveMessage" class="hidden mt-4 rounded-2xl p-4 text-sm font-semibold text-center border result-appear" style="animation-delay:0.1s"></div>
        </div>
    </div>

    <!-- Reference Card -->
    <div class="glass-card rounded-3xl p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-800">Referensi Rentang GDS</h3>
        </div>

        <div class="space-y-3">
            <div class="status-card flex items-center justify-between p-4 bg-green-50/70 rounded-2xl border border-green-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-green-900">Normal</span>
                        <span class="text-xs text-green-700/70">Gula darah ideal</span>
                    </div>
                </div>
                <span class="text-sm font-extrabold text-green-700 tabular-nums">80 – 180</span>
            </div>

            <div class="status-card flex items-center justify-between p-4 bg-yellow-50/70 rounded-2xl border border-yellow-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-yellow-900">Tinggi</span>
                        <span class="text-xs text-yellow-700/70">Perlu perhatian</span>
                    </div>
                </div>
                <span class="text-sm font-extrabold text-yellow-700 tabular-nums">&gt; 180</span>
            </div>

            <div class="status-card flex items-center justify-between p-4 bg-red-50/70 rounded-2xl border border-red-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-red-900">Sangat Tinggi</span>
                        <span class="text-xs text-red-700/70">Segera konsultasi</span>
                    </div>
                </div>
                <span class="text-sm font-extrabold text-red-700 tabular-nums">≥ 300</span>
            </div>

            <div class="status-card flex items-center justify-between p-4 bg-orange-50/70 rounded-2xl border border-orange-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-orange-900">Beresiko Rendah</span>
                        <span class="text-xs text-orange-700/70">Hati-hati hipoglikemia</span>
                    </div>
                </div>
                <span class="text-sm font-extrabold text-orange-700 tabular-nums">70 – 79</span>
            </div>

            <div class="status-card flex items-center justify-between p-4 bg-blue-50/70 rounded-2xl border border-blue-100/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-sm font-bold text-blue-900">Sangat Rendah</span>
                        <span class="text-xs text-blue-700/70">Hipoglikemia berat</span>
                    </div>
                </div>
                <span class="text-sm font-extrabold text-blue-700 tabular-nums">&lt; 70</span>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
let gdsCategory = '';
let gdsValue = 0;

function checkGDS() {
    const value = parseInt(document.getElementById('gdsValue').value);
    const resultDiv = document.getElementById('gdsResult');
    const badge = document.getElementById('gdsStatusBadge');
    const icon = document.getElementById('gdsStatusIcon');
    const message = document.getElementById('gdsMessage');
    const recommendation = document.getElementById('gdsRecommendation');
    const recBox = document.getElementById('gdsRecommendationBox');
    const saveArea = document.getElementById('gdsSaveArea');
    const saveMsg = document.getElementById('gdsSaveMessage');
    const gaugeMarker = document.getElementById('gaugeMarker');
    const gaugeValue = document.getElementById('gaugeValue');

    saveArea.classList.add('hidden');
    saveMsg.classList.add('hidden');

    if (isNaN(value) || value <= 0) {
        resultDiv.classList.remove('hidden');
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-500';
        badge.innerHTML = '&#9888;&#65039; Input Tidak Valid';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-gray-100 text-gray-500';
        icon.innerHTML = '&#9888;&#65039;';
        message.textContent = 'Harap masukkan nilai gula darah yang valid.';
        recBox.classList.add('hidden');
        gaugeMarker.style.left = '0%';
        gaugeValue.textContent = '—';
        return;
    }

    resultDiv.classList.remove('hidden');
    gdsValue = value;

    // Calculate gauge position (0-400 scale, cap at 100%)
    const gaugePct = Math.min((value / 400) * 100, 100);
    gaugeMarker.style.left = gaugePct + '%';
    gaugeValue.textContent = value + ' mg/dL';

    if (value >= 300) {
        gdsCategory = 'Sangat Tinggi';
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700';
        badge.innerHTML = '&#9888;&#65039; Sangat Tinggi';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-red-100 text-red-600';
        icon.innerHTML = '&#9888;&#65039;';
        message.textContent = 'Gula darah sangat tinggi, segera konsultasi ke dokter!';
        recBox.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong sangat tinggi (hiperglikemia berat). Segera hubungi dokter atau fasilitas kesehatan terdekat. Periksa kembali kadar gula darah Anda dan hindari makanan tinggi gula.';
        gaugeMarker.style.borderColor = '#ef4444';
        gaugeMarker.style.color = '#ef4444';
    } else if (value > 180) {
        gdsCategory = 'Tinggi';
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700';
        badge.innerHTML = '&#9888;&#65039; Tinggi';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-yellow-100 text-yellow-600';
        icon.innerHTML = '&#9888;&#65039;';
        message.textContent = 'Gula darah tinggi';
        recBox.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL berada di atas batas normal. Disarankan untuk memantau pola makan, mengurangi asupan karbohidrat sederhana, serta berkonsultasi dengan dokter jika hasil tetap tinggi.';
        gaugeMarker.style.borderColor = '#f59e0b';
        gaugeMarker.style.color = '#f59e0b';
    } else if (value >= 80 && value <= 180) {
        gdsCategory = 'Normal';
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 text-green-700';
        badge.innerHTML = '&#10004;&#65039; Normal';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-green-100 text-green-600';
        icon.innerHTML = '&#10004;&#65039;';
        message.textContent = 'Gula darah normal';
        recBox.classList.add('hidden');
        gaugeMarker.style.borderColor = '#22c55e';
        gaugeMarker.style.color = '#22c55e';
    } else if (value >= 70) {
        gdsCategory = 'Rendah';
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-orange-100 text-orange-700';
        badge.innerHTML = '&#9888;&#65039; Beresiko';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-orange-100 text-orange-600';
        icon.innerHTML = '&#9888;&#65039;';
        message.textContent = 'Gula darah rendah';
        recBox.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong rendah. Segera konsumsi makanan atau minuman manis seperti jus buah atau permen. Pantau gula darah kembali dalam 15 menit.';
        gaugeMarker.style.borderColor = '#f97316';
        gaugeMarker.style.color = '#f97316';
    } else {
        gdsCategory = 'Sangat Rendah';
        badge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-100 text-blue-700';
        badge.innerHTML = '&#9888;&#65039; Sangat Rendah';
        icon.className = 'w-10 h-10 rounded-full flex items-center justify-center text-lg shadow-md bg-blue-100 text-blue-600';
        icon.innerHTML = '&#9888;&#65039;';
        message.textContent = 'Gula darah sangat rendah, kondisi berbahaya!';
        recBox.classList.remove('hidden');
        recommendation.textContent = 'Nilai GDS ' + value + ' mg/dL tergolong hipoglikemia berat. Segera konsumsi glukosa cepat serap (gula, jus, atau glukosa tablet) dan cari bantuan medis darurat jika gejala tidak membaik.';
        gaugeMarker.style.borderColor = '#3b82f6';
        gaugeMarker.style.color = '#3b82f6';
    }

    saveArea.classList.remove('hidden');
}

function saveGDS() {
    const btn = document.getElementById('gdsSaveBtn');
    const msg = document.getElementById('gdsSaveMessage');
    const notes = document.getElementById('gdsNotes').value;

    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 inline-block mr-1.5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Menyimpan...';

    fetch('{{ route('blood-sugar.save') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            type: 'GDS',
            value: gdsValue,
            category: gdsCategory,
            notes: notes
        })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('gdsSaveMessage');
        msg.classList.remove('hidden');
        if (data.success) {
            msg.className = 'mt-4 rounded-2xl p-4 text-sm font-semibold text-center border bg-green-50 border-green-200 text-green-700';
            msg.innerHTML = '&#10004;&#65039; Hasil <strong>' + gdsValue + ' mg/dL</strong> (' + gdsCategory + ') berhasil disimpan!';
            document.getElementById('gdsSaveArea').classList.add('hidden');
        } else {
            msg.className = 'mt-4 rounded-2xl p-4 text-sm font-semibold text-center border bg-red-50 border-red-200 text-red-700';
            msg.textContent = data.message || 'Gagal menyimpan. Coba lagi.';
        }
    })
    .catch(() => {
        const msg = document.getElementById('gdsSaveMessage');
        msg.classList.remove('hidden');
        msg.className = 'mt-4 rounded-2xl p-4 text-sm font-semibold text-center border bg-red-50 border-red-200 text-red-700';
        msg.textContent = 'Terjadi kesalahan. Coba lagi.';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<svg class="w-5 h-5 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Simpan Hasil';
    });
}
</script>
@endpush