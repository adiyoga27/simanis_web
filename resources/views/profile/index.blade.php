@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="card">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-full gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/30 shrink-0">
                <span class="text-4xl font-extrabold text-white">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-400">{{ '@' . $user->username }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-primary shrink-0 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Informasi Pribadi</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Tanggal Lahir</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Jenis Kelamin</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->gender == 'L' ? 'Laki-laki' : ($user->gender == 'P' ? 'Perempuan' : '-') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Golongan Darah</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->blood_type ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">No. Telepon</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->phone ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Kesehatan</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Tinggi Badan</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->height ? $user->height . ' cm' : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Berat Badan</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->weight ? $user->weight . ' kg' : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Merokok</span>
                    <span class="text-sm font-medium {{ $user->smoking ? 'text-red-600' : 'text-green-600' }}">{{ $user->smoking ? 'Ya' : 'Tidak' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Riwayat Medis</span>
                    <span class="text-sm font-medium text-gray-800 text-right max-w-[200px] truncate">{{ $user->medical_history ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">Alamat</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Provinsi</span>
                <span class="text-sm font-medium text-gray-800">{{ $user->province ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Kota</span>
                <span class="text-sm font-medium text-gray-800">{{ $user->city ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Kecamatan</span>
                <span class="text-sm font-medium text-gray-800">{{ $user->district ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                <span class="text-sm text-gray-500">Kelurahan</span>
                <span class="text-sm font-medium text-gray-800">{{ $user->village ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-gray-50 sm:col-span-2">
                <span class="text-sm text-gray-500">Alamat Lengkap</span>
                <span class="text-sm font-medium text-gray-800 text-right max-w-[300px]">{{ $user->address ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 sm:col-span-2">
                <span class="text-sm text-gray-500">Kode Pos</span>
                <span class="text-sm font-medium text-gray-800">{{ $user->postal_code ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('profile.edit') }}" class="btn-primary w-full sm:w-auto text-center">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Edit Profil
            </span>
        </a>
        <a href="{{ route('profile.password') }}" class="btn-pink w-full sm:w-auto text-center">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
                Ganti Password
            </span>
        </a>
        <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full btn-white text-red-500 border-red-200 hover:bg-red-50 hover:text-red-600">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </span>
            </button>
        </form>
    </div>
</div>
@endsection
