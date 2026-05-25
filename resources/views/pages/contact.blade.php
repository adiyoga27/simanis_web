@extends('layouts.guest')

@section('title', 'Kontak')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-10">
            <div class="w-16 h-16 gradient-hero rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Hubungi Kami</h1>
            <p class="text-gray-500 mt-2">Kami siap membantu Anda</p>
        </div>

        <div class="space-y-6">
            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Kontak</h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-primary-50 to-pink-50 rounded-xl">
                        <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">info@codingaja.com</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-primary-50 to-pink-50 rounded-xl">
                        <div class="w-10 h-10 bg-pink-500 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Website</p>
                            <p class="font-semibold text-gray-800">diamondcare.id</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-primary-50 to-pink-50 rounded-xl">
                        <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-semibold text-gray-800">Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3">Butuh Bantuan?</h2>
                <p class="text-gray-600 leading-relaxed">
                    Jika Anda memiliki pertanyaan, saran, atau masukan terkait aplikasi Diamond Care, 
                    jangan ragu untuk menghubungi kami melalui email di atas. Tim kami akan merespons 
                    dalam waktu 1-2 hari kerja.
                </p>
            </div>

            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('login') }}" class="btn-white">Kembali</a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
