@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Beranda')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    {{-- Welcome Header --}}
    <div class="relative overflow-hidden rounded-3xl gradient-hero p-8 text-white shadow-xl shadow-primary-600/20">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/3 -translate-x-1/4"></div>
        <div class="relative z-10">
            <p class="text-pink-200 font-medium">Selamat datang kembali,</p>
            <h2 class="text-3xl lg:text-4xl font-extrabold mt-1">{{ Auth::user()->name ?? 'User' }}</h2>
            <p class="mt-2 text-white/80 max-w-lg">Pantau kondisi diabetes Anda secara berkala. Screening kaki, edukasi, gula darah — semua dalam satu genggaman.</p>
        </div>
    </div>

    {{-- Hero Banner Card --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-primary-600 via-pink-600 to-primary-700 p-8 lg:p-10 shadow-2xl shadow-pink-500/20">
        <div class="absolute inset-0 opacity-10">
            <svg class="absolute -top-20 -right-20 w-96 h-96 text-white" fill="currentColor" viewBox="0 0 512 512">
                <path d="M256 48C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48zm0 384c-97 0-176-79-176-176S159 80 256 80s176 79 176 176-79 176-176 176zm0-280c-57.4 0-104 46.6-104 104s46.6 104 104 104 104-46.6 104-104-46.6-104-104-104zm0 160c-30.9 0-56-25.1-56-56s25.1-56 56-56 56 25.1 56 56-25.1 56-56 56z"/>
            </svg>
        </div>
        <div class="relative z-10 text-center">
            <h1 class="text-3xl lg:text-5xl font-extrabold text-white text-shadow">Diamond Care</h1>
            <p class="text-xl lg:text-2xl font-semibold text-pink-200 mt-2">Manajemen Diabetes</p>
            <p class="text-white/70 mt-4 text-lg">#sehatkayabahagia</p>
        </div>
    </div>

    {{-- 4 Shortcut Cards --}}
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Utama</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Screening Kaki --}}
            <a href="{{ route('foot-screening') }}" class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] p-6 gradient-primary group cursor-pointer block">
                <div class="absolute top-3 right-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2a4 4 0 00-4 4c0 1.1.46 2.1 1.2 2.83L3.93 20.17c-.12.19-.18.4-.18.62 0 .67.54 1.21 1.21 1.21h14.08c.67 0 1.21-.54 1.21-1.21 0-.22-.06-.43-.18-.62l-5.27-11.34A4 4 0 0016 6a4 4 0 00-4-4zm0 2a2 2 0 012 2 2 2 0 01-2 2 2 2 0 01-2-2c0-1.1.9-2 2-2zm-1.5 6h3l3.5 7.5-4-1.5-2.5-6z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Screening Kaki</h3>
                    <p class="text-white/80 mt-1">Periksa kondisi kaki Anda</p>
                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-white/90 group-hover:text-white transition-colors">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Pilar Tata Laksana --}}
            <a href="{{ route('education') }}" class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] p-6 gradient-pink group cursor-pointer block">
                <div class="absolute top-3 right-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1zm0 13.5c-1.1-.35-2.3-.5-3.5-.5-1.7 0-4.15.65-5.5 1.5V8c1.35-.85 3.8-1.5 5.5-1.5 1.2 0 2.4.15 3.5.5v11.5z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Pilar Tata Laksana</h3>
                    <p class="text-white/80 mt-1">Edukasi, Nutrisi, Latihan & Perawatan</p>
                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-white/90 group-hover:text-white transition-colors">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Farmakologi --}}
            <a href="{{ route('pharmacology') }}" class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] p-6 bg-gradient-to-br from-pink-500 to-primary-500 group cursor-pointer block">
                <div class="absolute top-3 right-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.5 2h-13C4.12 2 3 3.12 3 4.5v15C3 20.88 4.12 22 5.5 22h13c1.38 0 2.5-1.12 2.5-2.5v-15C21 3.12 19.88 2 18.5 2zM16 14H8v-4h8v4z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Farmakologi</h3>
                    <p class="text-white/80 mt-1">Informasi pengobatan diabetes</p>
                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-white/90 group-hover:text-white transition-colors">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>

            {{-- Pemantauan Gula Darah --}}
            <a href="{{ route('blood-sugar') }}" class="relative overflow-hidden rounded-2xl shadow-xl transition-transform duration-300 hover:scale-[1.02] active:scale-[0.98] p-6 bg-gradient-to-br from-primary-400 to-pink-400 group cursor-pointer block">
                <div class="absolute top-3 right-3 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15l-4-4 1.41-1.41L11 14.17l6.59-6.59L19 9l-8 8z"/>
                    </svg>
                </div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center mb-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Pemantauan Gula Darah</h3>
                    <p class="text-white/80 mt-1">Cek kadar gula darah Anda</p>
                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-white/90 group-hover:text-white transition-colors">
                        Lihat Selengkapnya
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
        </div>
    </div>

    {{-- Stats Section --}}
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h3>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            <div class="stat-card">
                <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div class="stat-value">{{ $educationCount }}</div>
                <div class="stat-label">Total Edukasi</div>
            </div>
            <div class="stat-card">
                <div class="w-10 h-10 rounded-xl bg-pink-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
                </div>
                <div class="stat-value text-pink-500">{{ $footScreeningCount }}</div>
                <div class="stat-label">Screening Kaki</div>
            </div>
            <div class="stat-card">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div class="stat-value text-red-500">{{ $bloodSugarCount }}</div>
                <div class="stat-label">Gula Darah</div>
            </div>
            <div class="stat-card">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h1m16 0h1M5.5 5.5l.7.7m11.6 11.6l.7.7M5.5 18.5l.7-.7m11.6-11.6l.7-.7M12 3v1m0 16v1M8.5 6.5a3.5 3.5 0 107 0 3.5 3.5 0 00-7 0zm7 7a3.5 3.5 0 10-7 0 3.5 3.5 0 007 0z"/></svg>
                </div>
                <div class="stat-value text-green-600">{{ $weightLogCount }}</div>
                <div class="stat-label">Berat Badan</div>
            </div>
            <div class="stat-card">
                <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="stat-value text-yellow-600">{{ $medicationCount }}</div>
                <div class="stat-label">Jadwal Obat</div>
            </div>
        </div>
    </div>

    {{-- Recent Blood Sugar --}}
    @if($recentBloodSugar->count() > 0)
    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Gula Darah Terbaru</h3>
        <div class="card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="px-5 py-3 font-semibold text-gray-600">Tipe</th>
                            <th class="px-5 py-3 font-semibold text-gray-600">Nilai</th>
                            <th class="px-5 py-3 font-semibold text-gray-600">Kategori</th>
                            <th class="px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentBloodSugar as $record)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-5 py-3">
                                @if($record->type === 'GDP')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-primary-100 text-primary-700">GDP</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700">GDS</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 font-semibold text-gray-800">{{ $record->value }} <span class="text-gray-400 font-normal text-xs">mg/dL</span></td>
                            <td class="px-5 py-3">
                                @php
                                    $catColor = match($record->category) {
                                        'Normal' => 'bg-green-100 text-green-700',
                                        'Tinggi' => 'bg-yellow-100 text-yellow-700',
                                        'Sangat Tinggi' => 'bg-red-100 text-red-700',
                                        'Rendah' => 'bg-orange-100 text-orange-700',
                                        'Sangat Rendah' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $catColor }}">{{ $record->category }}</span>
                            </td>
                            <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $record->recorded_at->format('d M Y, H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
