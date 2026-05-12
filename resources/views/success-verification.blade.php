@extends('layouts.guest')

@section('title', 'Verifikasi Email Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="card text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Verifikasi Email Berhasil!</h2>
            <p class="text-gray-600 mb-4">
                Halo <span class="font-semibold text-primary-600">{{ $user->name }}</span>, 
                akun Anda telah berhasil diverifikasi.
            </p>
            <p class="text-gray-500 text-sm mb-6">
                Anda sekarang dapat mengakses semua fitur SIMANIS. 
                Selamat menggunakan aplikasi manajemen diabetes kami.
            </p>

            <a href="{{ route('login') }}" class="btn-primary inline-block">
                Masuk ke Aplikasi
            </a>

            <p class="text-xs text-gray-400 mt-6">
                &copy; {{ date('Y') }} SIMANIS. #sehatkayabahagia
            </p>
        </div>
    </div>
</div>
@endsection
