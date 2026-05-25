@extends('layouts.guest')

@section('title', 'Diamond Care - Kelola Diabetes Anda dengan Lebih Baik')

@section('content')
{{-- Navbar --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100/50 transition-all duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-11 lg:h-11 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30 animate-pulse">
                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.698 50.698 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl lg:text-2xl font-bold text-gray-800 tracking-tight">Diamond Care</h1>
                    <p class="text-xs text-gray-400 -mt-0.5">#sehatkayabahagia</p>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-8">
                <a href="#features" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Fitur</a>
                <a href="#about" class="text-sm font-medium text-gray-600 hover:text-primary-500 transition-colors">Tentang</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-primary-600 hover:text-primary-700 transition-colors px-4 py-2">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary text-sm !py-2 !px-5 hidden sm:inline-flex">Daftar</a>
            </div>
        </div>
    </div>
</header>

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
    <div class="absolute inset-0 gradient-hero"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-pink-400/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-primary-400/20 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
        <div class="animate__animated animate__fadeInUp" style="animation: fadeInUp 0.8s ease-out;">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white/90 text-sm font-medium mb-8 border border-white/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                #sehatkayabahagia
            </span>
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-white tracking-tight leading-tight" style="animation: fadeInUp 0.8s ease-out 0.1s both;">
            Kelola Diabetes Anda<br class="hidden sm:block"> dengan <span class="text-pink-200">Lebih Baik</span>
        </h1>
        <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-white/80 leading-relaxed" style="animation: fadeInUp 0.8s ease-out 0.2s both;">
            Diamond Care membantu Anda memantau gula darah, melakukan screening kaki diabetik, mendapatkan edukasi diabetes, dan mengatur terapi nutrisi — semua dalam satu aplikasi.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4" style="animation: fadeInUp 0.8s ease-out 0.3s both;">
            <a href="{{ route('login') }}" class="btn-white w-full sm:w-auto text-center !text-base !py-3.5 !px-10 !rounded-2xl">
                <span class="flex items-center justify-center gap-2">
                    Mulai Sekarang
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </span>
            </a>
            <a href="{{ route('register') }}" class="btn-pink w-full sm:w-auto text-center !text-base !py-3.5 !px-10 !rounded-2xl">
                <span class="flex items-center justify-center gap-2">
                    Daftar Gratis
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </span>
            </a>
        </div>
        <div class="mt-16 flex items-center justify-center gap-8 text-white/60 text-sm" style="animation: fadeInUp 0.8s ease-out 0.4s both;">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Screening Kaki
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Gula Darah
            </div>
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Edukasi
            </div>
        </div>
        <div class="mt-12" style="animation: fadeInUp 0.8s ease-out 0.5s both;">
            <a href="#features" class="inline-flex flex-col items-center text-white/50 hover:text-white/80 transition-colors">
                <span class="text-xs font-medium mb-2">Scroll untuk jelajahi</span>
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section id="features" class="relative py-24 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 lg:mb-20">
            <span class="badge-pink mb-4">Fitur Unggulan</span>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mt-4">
                Semua yang Anda Butuhkan<br>untuk <span class="text-primary-600">Mengelola Diabetes</span>
            </h2>
            <p class="mt-4 text-gray-500 text-lg">
                Empat pilar utama kami membantu Anda mengontrol diabetes dengan lebih percaya diri setiap hari.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            {{-- Card 1: Screening Kaki Diabetik --}}
            <div class="card hover:border-primary-200 hover:shadow-xl hover:shadow-primary-100/50 group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-5 mb-2">Screening Kaki Diabetik</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Deteksi dini risiko masalah kaki diabetik dengan kuesioner skrining komprehensif dan rekomendasi perawatan.</p>
            </div>

            {{-- Card 2: Pemantauan Gula Darah --}}
            <div class="card hover:border-primary-200 hover:shadow-xl hover:shadow-primary-100/50 group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl gradient-pink flex items-center justify-center shadow-lg shadow-pink-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-5 mb-2">Pemantauan Gula Darah</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Catat dan pantau kadar gula darah harian (GDP & GDS) dengan grafik yang mudah dipahami dan tutorial lengkap.</p>
            </div>

            {{-- Card 3: Edukasi Diabetes --}}
            <div class="card hover:border-primary-200 hover:shadow-xl hover:shadow-primary-100/50 group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-5 mb-2">Edukasi Diabetes</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Akses materi edukasi lengkap tentang pilar tata laksana diabetes dari sumber terpercaya dan mudah dipahami.</p>
            </div>

            {{-- Card 4: Terapi Nutrisi --}}
            <div class="card hover:border-primary-200 hover:shadow-xl hover:shadow-primary-100/50 group cursor-pointer">
                <div class="w-14 h-14 rounded-2xl gradient-pink flex items-center justify-center shadow-lg shadow-pink-500/20 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mt-5 mb-2">Terapi Nutrisi</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Hitung kebutuhan kalori harian dan dapatkan panduan nutrisi yang sesuai dengan kondisi diabetes Anda.</p>
            </div>
        </div>
    </div>
</section>

{{-- About Section --}}
<section id="about" class="relative py-24 lg:py-32 bg-gradient-to-b from-pink-50 via-white to-red-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            <div class="relative">
                <div class="w-full h-64 sm:h-80 lg:h-96 gradient-primary rounded-3xl flex items-center justify-center shadow-2xl shadow-primary-500/20">
                    <svg class="w-24 h-24 sm:w-32 sm:h-32 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.698 50.698 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                    </svg>
                </div>
                <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-pink-400/30 rounded-3xl blur-2xl"></div>
            </div>
            <div class="mt-12 lg:mt-0">
                <span class="badge-pink">Tentang Diamond Care</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 tracking-tight mt-4">
                    Partner Sehat untuk <span class="text-primary-600">Hidup Lebih Baik</span>
                </h2>
                <p class="mt-6 text-gray-600 leading-relaxed text-lg">
                    Diamond Care adalah aplikasi manajemen diabetes melitus yang dirancang untuk membantu Anda mengontrol kondisi diabetes secara holistik. Dari pemantauan gula darah, screening kaki diabetik, hingga edukasi dan panduan nutrisi — kami hadir sebagai teman perjalanan kesehatan Anda.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="btn-primary !text-base !py-3.5 !px-8 !rounded-2xl">Mulai Perjalanan Sehat</a>
                    <a href="{{ route('about') }}" class="btn-white !text-base !py-3.5 !px-8 !rounded-2xl">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-gray-900 text-white py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Diamond Care</h3>
                    <p class="text-xs text-gray-400">#sehatkayabahagia</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-6 text-sm text-gray-400">
                <a href="{{ route('about') }}" class="hover:text-white transition-colors">Tentang</a>
                <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privasi</a>
                <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontak</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-500 flex items-center justify-center transition-colors group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-500 flex items-center justify-center transition-colors group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-500 flex items-center justify-center transition-colors group">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>
                </a>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-white/10 text-center">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Diamond Care. All rights reserved. Dibuat dengan ❤️ untuk Indonesia sehat.</p>
        </div>
    </div>
</footer>

@push('scripts')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush
@endsection
