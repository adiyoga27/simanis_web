@extends('layouts.app')

@section('title', 'Screening Kaki Diabetik')
@section('page-title', 'Screening Kaki Diabetik')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Hero Information Card -->
    <div class="card overflow-hidden">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg">Pentingnya Screening Kaki Diabetik</h3>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed text-sm mb-4">Screening kaki diabetik adalah pemeriksaan rutin untuk mendeteksi dini masalah pada kaki penderita diabetes. Komplikasi kaki diabetik dapat dicegah dengan deteksi dini dan perawatan yang tepat.</p>
                <a href="{{ route('foot-screening.survey') }}" class="btn-primary inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Mulai Screening
                </a>
            </div>
            <div class="md:w-48 shrink-0">
                <div class="w-full aspect-square rounded-2xl bg-gradient-to-br from-pink-50 to-primary-50 flex items-center justify-center border-2 border-dashed border-pink-200">
                    <div class="text-center">
                        <svg class="w-12 h-12 text-pink-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-xs text-gray-400">Diagram Kaki</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Risk Factor Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="card border-l-4 border-l-primary-500">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Neuropati</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Kerusakan saraf menyebabkan mati rasa, kesemutan, atau nyeri pada kaki.</p>
                </div>
            </div>
        </div>

        <div class="card border-l-4 border-l-pink-500">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-pink-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Sirkulasi Darah Buruk</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Aliran darah yang buruk ke kaki memperlambat penyembuhan luka.</p>
                </div>
            </div>
        </div>

        <div class="card border-l-4 border-l-yellow-500">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Infeksi</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Luka kecil dapat berkembang menjadi infeksi serius jika tidak ditangani.</p>
                </div>
            </div>
        </div>

        <div class="card border-l-4 border-l-green-500">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800">Pencegahan</h4>
                    <p class="text-sm text-gray-500 mt-0.5">Pemeriksaan rutin dan perawatan kaki harian dapat mencegah komplikasi serius.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Card -->
    <div class="gradient-pink rounded-2xl p-6 text-center text-white shadow-lg shadow-pink-500/30">
        <svg class="w-12 h-12 mx-auto mb-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/>
        </svg>
        <h3 class="text-xl font-bold mb-2">Lindungi Kaki Anda Sekarang</h3>
        <p class="text-white/80 text-sm mb-5">Deteksi dini adalah kunci pencegahan. Lakukan screening kaki diabetik secara berkala.</p>
        <a href="{{ route('foot-screening.survey') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Mulai Screening Sekarang
        </a>
    </div>

</div>
@endsection
