<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Diamond Care - Aplikasi Manajemen Diabetes Melitus. Pantau gula darah, screening kaki, edukasi, terapi nutrisi, dan manajemen pengobatan.">
    <meta name="keywords" content="Diamond Care, diabetes, gula darah, screening kaki, edukasi diabetes, nutrisi diabetes">
    <meta name="author" content="Diamond Care">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'Dashboard') - Diamond Care</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('overlay').classList.add('hidden');
        }
        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu');
            const btn = document.getElementById('userMenuBtn');
            if (menu && btn && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-red-50 min-h-screen">
    <div id="overlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-white border-r border-gray-100 shadow-xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.698 50.698 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" /></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Diamond Care</h2>
                    <p class="text-xs text-gray-400">#sehatkayabahagia</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @if(Auth::user()->role === 'pasien')
            <a href="{{ route('home') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                Beranda
            </a>
            <a href="{{ route('foot-screening') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('foot-screening*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" /></svg>
                Screening Kaki
            </a>
            <a href="{{ route('assessment.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('assessment*') && !request()->routeIs('admin.assessments*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Diabetes Kaki
            </a>
            <a href="{{ route('education') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('education*') && !request()->routeIs('education.article') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                Pilar Tata Laksana
            </a>
            <a href="{{ route('pharmacology') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('pharmacology') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Farmakologi
            </a>
            <a href="{{ route('blood-sugar') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('blood-sugar*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                Pemantauan Gula Darah
            </a>
            <a href="{{ route('instruments.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('instruments*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Instrument Keyakinan
            </a>
            @endif

            @if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa', 'kader']))
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            {{-- Data Master --}}
            <div class="pt-4 mt-4 border-t border-gray-100">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Data Master</p>
            </div>
            <a href="{{ route('admin.users') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                Manajemen User
            </a>
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('admin.desa.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.desa*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Manajemen Desa
            </a>
            @endif
            <a href="{{ route('admin.assessments.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.assessments*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Assessments
            </a>
            <a href="{{ route('admin.instruments.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.instruments*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Instrument Keyakinan
            </a>
            <a href="{{ route('admin.education.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.education*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Edukasi
            </a>

            {{-- Monitoring --}}
            <div class="pt-4 mt-4 border-t border-gray-100">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Monitoring</p>
            </div>
            <a href="{{ route('admin.monitoring.foot-screening') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.foot-screening*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
                Screening Kaki
            </a>
            <a href="{{ route('admin.monitoring.assessments') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.assessments*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Diabetes Kaki
            </a>
            <a href="{{ route('admin.monitoring.blood-sugar') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.blood-sugar*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Riwayat Gula Darah
            </a>
            <a href="{{ route('admin.instruments.results') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.instruments.results*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Instrumen Keyakinan
            </a>

            {{-- Tools --}}
            <div class="pt-4 mt-4 border-t border-gray-100">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tools</p>
            </div>
            <a href="{{ route('admin.logs') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Log System
            </a>
            @endif
        </nav>

        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST" onsubmit="closeSidebar()">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all duration-200 font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:pl-72 flex flex-col min-h-screen">
        <!-- Top Navbar -->
        <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-100">
            <div class="flex items-center justify-between px-4 lg:px-8 h-16">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl hover:bg-gray-100 transition-colors">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div class="flex items-center gap-3 lg:hidden">
                        <div class="w-8 h-8 gradient-primary rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" /></svg>
                        </div>
                        <span class="font-bold text-gray-800">Diamond Care</span>
                    </div>
                    <h1 class="hidden lg:block text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>

                <!-- User Menu (top-right) -->
                <div class="relative">
                    <button id="userMenuBtn" onclick="toggleUserMenu()" class="flex items-center gap-2 sm:gap-2.5 px-2 sm:px-3 py-1.5 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center text-white font-bold text-xs shrink-0">
                            {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-semibold text-gray-800 leading-tight truncate max-w-[120px]">{{ Auth::user()?->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 leading-tight">@ {{ Auth::user()?->username ?? 'user' }}</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="userMenu" class="hidden absolute right-0 top-full mt-3 w-64 bg-white rounded-2xl shadow-2xl shadow-gray-300/50 border border-gray-100 z-50 overflow-hidden">
                        {{-- Mobile: user info header --}}
                        <div class="sm:hidden flex items-center gap-3 px-5 py-4 bg-gray-50/80 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-md shadow-pink-400/20">
                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()?->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-400 truncate">@ {{ Auth::user()?->username ?? 'user' }}</p>
                            </div>
                        </div>
                        <div class="py-2">
                            <a href="{{ route('profile') }}" onclick="document.getElementById('userMenu').classList.add('hidden')" class="flex items-center gap-3.5 mx-2 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-xl transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-gray-800">Profil Saya</p>
                                    <p class="text-xs text-gray-400">Lihat dan edit profil</p>
                                </div>
                            </a>
                            <a href="{{ route('change.password') }}" onclick="document.getElementById('userMenu').classList.add('hidden')" class="flex items-center gap-3.5 mx-2 px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-xl transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <div class="text-left">
                                    <p class="font-medium text-gray-800">Ubah Kata Sandi</p>
                                    <p class="text-xs text-gray-400">Ganti kata sandi akun</p>
                                </div>
                            </a>
                            <div class="mx-4 my-2 border-t border-gray-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-3.5 w-full mx-2 px-3 py-2.5 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-colors" style="width: calc(100% - 16px);">
                                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-medium">Keluar</p>
                                        <p class="text-xs text-red-300">Akhiri sesi</p>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-100 bg-white/50 backdrop-blur-sm py-4 px-4 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm text-gray-400">
                <p>&copy; {{ date('Y') }} Diamond Care. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('about') }}" class="hover:text-gray-600 transition-colors">Tentang</a>
                    <a href="{{ route('privacy') }}" class="hover:text-gray-600 transition-colors">Privasi</a>
                    <a href="{{ route('terms') }}" class="hover:text-gray-600 transition-colors">Syarat & Ketentuan</a>
                </div>
                <p>#sehatkayabahagia</p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>
