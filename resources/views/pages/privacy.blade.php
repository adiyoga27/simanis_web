@extends('layouts.guest')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl">
        <div class="text-center mb-10">
            <div class="w-16 h-16 gradient-pink rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-pink-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Kebijakan Privasi</h1>
            <p class="text-gray-500 mt-2">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>

        <div class="space-y-6">
            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Informasi yang Kami Kumpulkan</h2>
                <p class="text-gray-600 leading-relaxed">
                    SIMANIS mengumpulkan informasi yang Anda berikan secara langsung, termasuk nama, 
                    alamat email, username, data kesehatan (tinggi badan, berat badan, golongan darah, 
                    riwayat medis), dan data lokasi (provinsi, kota, alamat). Informasi ini digunakan 
                    untuk memberikan layanan manajemen diabetes yang dipersonalisasi.
                </p>
            </div>

            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Penggunaan Informasi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Informasi yang dikumpulkan digunakan untuk:
                </p>
                <ul class="list-disc list-inside space-y-1 text-gray-600 mt-2">
                    <li>Menyediakan layanan manajemen diabetes</li>
                    <li>Menghitung BMI dan kebutuhan kalori</li>
                    <li>Memberikan rekomendasi diet yang sesuai</li>
                    <li>Mengirim notifikasi verifikasi email</li>
                    <li>Meningkatkan kualitas layanan aplikasi</li>
                </ul>
            </div>

            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Keamanan Data</h2>
                <p class="text-gray-600 leading-relaxed">
                    Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang sesuai untuk 
                    melindungi data pribadi Anda dari akses, penggunaan, atau pengungkapan yang tidak sah. 
                    Data Anda disimpan dengan aman dan hanya dapat diakses oleh Anda melalui akun yang 
                    dilindungi kata sandi.
                </p>
            </div>

            <div class="card">
                <h2 class="text-lg font-bold text-gray-800 mb-2">Hak Pengguna</h2>
                <p class="text-gray-600 leading-relaxed">
                    Anda memiliki hak untuk mengakses, memperbarui, atau menghapus informasi pribadi Anda. 
                    Anda dapat mengelola profil Anda melalui halaman pengaturan akun. Jika Anda memiliki 
                    pertanyaan tentang kebijakan privasi ini, silakan hubungi kami.
                </p>
            </div>

            <div class="flex justify-center gap-4 pt-4">
                <a href="{{ route('login') }}" class="btn-white">Kembali</a>
                <a href="{{ route('contact') }}" class="btn-primary">Hubungi Kami</a>
            </div>
        </div>
    </div>
</div>
@endsection
