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
    </script>
</head>
<body class="bg-gradient-to-br from-pink-50 via-white to-red-50 min-h-screen">
    <div id="overlay" class="hidden fixed inset-0 bg-black/50 z-40 lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-72 bg-white border-r border-gray-100 shadow-xl z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="Diamond Care" class="w-10 h-10 rounded-xl">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Diamond Care</h2>
                    <p class="text-xs text-gray-400">#sehatkayabahagia</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @if(Auth::user()->role === 'pasien')
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
            @php
                $dataMasterActive = request()->routeIs([
                    'admin.patients*','admin.users*','admin.desa*',
                    'admin.instruments*','admin.education*'
                ]) || (request()->routeIs('admin.assessments*') && !request()->routeIs('admin.assessments.result*'))
                   || (request()->routeIs('admin.instruments*') && !request()->routeIs('admin.instruments.results*'));
            @endphp
            <button type="button" onclick="toggleDataMaster()" class="pt-4 mt-4 border-t border-gray-100 w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider hover:text-gray-500 transition-colors cursor-pointer {{ $dataMasterActive ? 'text-primary-600' : '' }}">
                <span>Data Master</span>
                <svg id="dataMasterChevron" class="w-3.5 h-3.5 transition-transform duration-200" style="transform: {{ $dataMasterActive ? 'rotate(180deg)' : 'rotate(0deg)' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div id="dataMasterMenu" class="space-y-1 {{ $dataMasterActive ? '' : 'hidden' }}">
            <a href="{{ route('admin.patients.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.patients*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Manajemen Pasien
            </a>
            @if(Auth::user()->role === 'superadmin')
            <a href="{{ route('admin.users') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                Manajemen User
            </a>
            <a href="{{ route('admin.desa.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.desa*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Manajemen Desa
            </a>
            <a href="{{ route('admin.assessments.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.assessments*') && !request()->routeIs('admin.assessments.result*') ? 'active' : '' }}">
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
            <a href="{{ route('admin.logs') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Log System
            </a>
            @endif
            </div>

            {{-- Monitoring --}}
            <div class="pt-4 mt-4 border-t border-gray-100">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Monitoring</p>
            </div>
            <a href="{{ route('admin.monitoring.education') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.education*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Pilar Tata Laksana
            </a>
            {{-- <a href="{{ route('admin.monitoring.foot-screening') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.foot-screening*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/></svg>
                Screening Kaki
            </a> --}}
            <a href="{{ route('admin.monitoring.assessments') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.assessments*') || request()->routeIs('admin.assessments.result*') || request()->routeIs('assessment*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                Screening Kaki
            </a>
            <a href="{{ route('admin.monitoring.blood-sugar') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.monitoring.blood-sugar*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                Pemantauan Gula Darah
            </a>
            <a href="{{ route('admin.pharmacology.index') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.pharmacology*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 20.5l10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 8.5l7 7"/></svg>
                Farmakologi
            </a>
            <a href="{{ route('admin.instruments.results') }}" onclick="closeSidebar()" class="sidebar-link {{ request()->routeIs('admin.instruments.results*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Instrumen Keyakinan
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
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Diamond Care" class="w-8 h-8 rounded-lg">
                        <span class="font-bold text-gray-800">Diamond Care</span>
                    </div>
                    <h1 class="hidden lg:block text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                </div>

                <!-- User Info (top-right) -->
                <div class="relative">
                    <button type="button" onclick="toggleUserMenu()" class="flex items-center gap-2 sm:gap-3 hover:bg-gray-50 rounded-2xl px-2 py-1.5 transition-colors cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center text-white font-bold text-xs shrink-0">
                            {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()?->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-400 leading-tight">
                                @php
                                    $roleLabels = [
                                        'superadmin' => 'Superadmin',
                                        'kepala_puskesmas' => 'Kepala Puskesmas',
                                        'kepala_desa' => 'Kepala Desa',
                                        'kader' => 'Kader',
                                        'pasien' => 'Pasien',
                                    ];
                                @endphp
                                {{ $roleLabels[Auth::user()?->role] ?? 'User' }}
                            </p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div id="userMenu" class="hidden absolute right-0 top-full mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 animate-fade-in">
                        <div class="px-4 py-3 border-b border-gray-50">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()?->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ Auth::user()?->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Profil Saya
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Profil
                            </a>
                            <a href="{{ route('change.password') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                Ganti Password
                            </a>
                        </div>
                        <div class="border-t border-gray-50 pt-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
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
    <script>
        function toggleDataMaster() {
            const menu = document.getElementById('dataMasterMenu');
            const chevron = document.getElementById('dataMasterChevron');
            menu.classList.toggle('hidden');
            if (chevron) {
                chevron.style.transform = menu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
            }
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu');
            const btn = e.target.closest('button[onclick*="toggleUserMenu"]');
            if (!btn && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
