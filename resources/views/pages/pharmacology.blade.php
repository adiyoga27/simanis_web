@extends('layouts.app')

@section('title', 'Farmakologi')
@section('page-title', 'Farmakologi')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="text-center mb-2">
        <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-pink-500">Manajemen Pengobatan Diabetes</h2>
        <p class="text-gray-400 mt-1">Informasi jadwal dan panduan konsumsi obat diabetes</p>
    </div>

    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-500 via-primary-600 to-pink-500 p-8 text-white shadow-xl shadow-primary-500/30">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Obat Oral (Diminum)</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Pagi</p>
                    <p class="text-xs text-white/70">06:00 - 08:00</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Siang</p>
                    <p class="text-xs text-white/70">12:00 - 13:00</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Sore</p>
                    <p class="text-xs text-white/70">16:00 - 17:00</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Malam</p>
                    <p class="text-xs text-white/70">19:00 - 20:00</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-l-4 border-l-pink-400">
        <div class="space-y-3 text-sm text-gray-600 leading-relaxed">
            <h4 class="text-base font-bold text-gray-800">Informasi Obat Oral</h4>
            <p>Obat oral diabetes adalah obat yang diminum untuk membantu mengontrol kadar gula darah. Beberapa jenis obat oral yang umum digunakan:</p>
            <ul class="list-disc list-inside space-y-1 ml-2">
                <li><span class="font-medium text-primary-600">Metformin</span> — menurunkan produksi glukosa hati dan meningkatkan sensitivitas insulin</li>
                <li><span class="font-medium text-primary-600">Sulfonilurea</span> — merangsang pankreas memproduksi lebih banyak insulin</li>
                <li><span class="font-medium text-primary-600">DPP-4 Inhibitor</span> — membantu tubuh mempertahankan kadar hormon incretin</li>
                <li><span class="font-medium text-primary-600">SGLT2 Inhibitor</span> — membantu ginjal membuang glukosa melalui urine</li>
            </ul>
            <div class="mt-2 p-3 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs">
                <strong>Penting:</strong> Konsultasikan dengan dokter Anda sebelum mengonsumsi atau mengubah dosis obat. Jangan menghentikan pengobatan tanpa persetujuan dokter.
            </div>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-400 via-pink-500 to-primary-400 p-8 text-white shadow-xl shadow-pink-500/30">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold">Insulin (Suntik)</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Sebelum Makan Pagi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Sebelum Makan Siang</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Sebelum Makan Malam</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center">
                    <div class="w-12 h-12 mx-auto rounded-full bg-white/20 flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">Sebelum Tidur</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-l-4 border-l-primary-400">
        <div class="space-y-3 text-sm text-gray-600 leading-relaxed">
            <h4 class="text-base font-bold text-gray-800">Informasi Terapi Insulin</h4>
            <p>Insulin adalah hormon yang membantu sel tubuh menyerap glukosa dari darah. Terapi insulin biasanya diberikan melalui suntikan. Beberapa jenis insulin:</p>
            <ul class="list-disc list-inside space-y-1 ml-2">
                <li><span class="font-medium text-pink-600">Insulin Kerja Cepat (Rapid-acting)</span> — mulai bekerja dalam 15 menit</li>
                <li><span class="font-medium text-pink-600">Insulin Kerja Pendek (Short-acting)</span> — mulai bekerja dalam 30 menit</li>
                <li><span class="font-medium text-pink-600">Insulin Kerja Menengah (Intermediate-acting)</span> — mulai bekerja dalam 2-4 jam</li>
                <li><span class="font-medium text-pink-600">Insulin Kerja Panjang (Long-acting)</span> — bekerja hingga 24 jam</li>
            </ul>
        </div>
    </div>

    <a href="{{ route('medications.index') }}" class="block relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-500 via-primary-600 to-pink-500 p-8 text-white shadow-xl shadow-primary-500/30 hover:shadow-2xl hover:shadow-primary-500/40 hover:scale-[1.02] transition-all duration-300">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
        <div class="relative flex flex-col sm:flex-row items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="text-center sm:text-left">
                <h4 class="text-xl font-bold">Kelola Jadwal Obat Anda</h4>
                <p class="text-sm text-white/80 mt-1">Atur jadwal, dosis, dan pengingat konsumsi obat diabetes Anda secara personal</p>
            </div>
            <div class="flex-shrink-0">
                <svg class="w-8 h-8 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </div>
        </div>
    </a>

    <div class="card bg-gradient-to-r from-gray-50 to-pink-50 border border-pink-100 text-center">
        <div class="flex flex-col items-center gap-3">
            <div class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h4 class="text-lg font-bold text-gray-800">Pengingat Pengobatan</h4>
                <p class="text-sm text-gray-500 mt-1">Fitur alarm pengingat minum obat tersedia di <span class="font-semibold text-pink-600">aplikasi mobile Diamond Care</span>. Unduh aplikasi kami untuk mendapatkan notifikasi tepat waktu.</p>
            </div>
        </div>
    </div>

</div>
@endsection
