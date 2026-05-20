@extends('layouts.app')

@section('title', 'Screening Kaki')
@section('page-title', 'Screening Kaki')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Hero Information Card -->
    <div class="card overflow-hidden">
        <div class="space-y-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pentingnya Screening Kaki Diabetik</h3>
                </div>
            </div>

            <div class="mx-auto max-w-md">
                <img src="{{ asset('images/sk.png') }}" alt="Diagram Kaki Diabetik" class="w-full rounded-2xl border border-gray-100 shadow-md">
            </div>

            <div>

                <p class="text-gray-600 leading-relaxed text-sm mb-4">Beberapa hal yang bisa diperhatikan saat melakukan deteksi dini kelainan kaki seperti :</p>

                <ul class="space-y-1.5 mb-4 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kulit kaku yang kering, bersisik, dan retak-retak serta kaku
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Rambut kaki yang menipis
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kelainan bentuk dan warna kuku (kuku yang menebal, rapuh, ingrowing nail)
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kalus (mata ikan) terutama di bagian telapak kaki
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perubahan bentuk jari-jari dan telapak kaki dan tulang-tulang kaki yang menonjol
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Bekas luka atau riwayat amputasi jari-jari
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kaki baal, kesemutan, atau tidak terasa nyeri
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kaki yang terasa dingin
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perubahan warna kulit kaki (kemerahan, kebiruan, atau kehitaman)
                    </li>
                </ul>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start gap-2.5">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-amber-800 leading-relaxed">Harus diperhatikan kaki diabetik dengan ulkus merupakan komplikasi yang sering terjadi. Biasanya luka tersebut berada di daerah bawah pergelangan kaki.</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('foot-screening.survey') }}" class="btn-primary inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        Check Kaki Anda
                    </a>
                    <a href="{{ route('foot-screening.history') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Riwayat Screening
                    </a>
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
            Check Kaki Anda
        </a>
    </div>

</div>
@endsection
