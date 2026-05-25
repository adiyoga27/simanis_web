@extends('layouts.guest')

@section('title', 'Syarat & Ketentuan')

@section('content')
<div class="min-h-screen">
    {{-- Header with logo --}}
    <div class="gradient-hero py-12 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <div class="w-16 h-16 gradient-primary rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.698 50.698 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white">SIMANIS</h1>
            <p class="text-primary-100 mt-1">Syarat & Ketentuan</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 -mt-8 pb-16">
        <div class="space-y-6">
            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 gradient-primary rounded-full inline-block"></span>
                    Pengantar
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Selamat datang di SIMANIS, aplikasi manajemen diri diabetes melitus. Dengan mengakses dan menggunakan aplikasi ini, Anda setuju untuk terikat dengan syarat dan ketentuan yang tercantum di bawah ini. Harap baca dengan saksama sebelum menggunakan layanan kami. Jika Anda tidak menyetujui ketentuan ini, harap tidak menggunakan aplikasi ini.
                </p>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 gradient-primary rounded-full inline-block"></span>
                    Layanan
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    SIMANIS merupakan aplikasi pendukung manajemen diabetes melitus yang menyediakan fitur pemantauan gula darah, screening kaki diabetik, edukasi kesehatan, terapi nutrisi, informasi farmakologi, dan manajemen pengobatan. Aplikasi ini ditujukan sebagai alat bantu dan tidak menggantikan konsultasi dengan tenaga medis profesional.
                </p>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 gradient-pink rounded-full inline-block"></span>
                    Akun Pengguna
                </h2>
                <p class="text-gray-600 leading-relaxed mb-3">
                    Pengguna bertanggung jawab untuk menjaga kerahasiaan akun dan kata sandi mereka. Pengguna setuju untuk memberikan informasi yang akurat, lengkap, dan terkini saat mendaftar. Segala aktivitas yang terjadi pada akun Anda sepenuhnya menjadi tanggung jawab Anda.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-primary-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Anda harus berusia minimal 17 tahun untuk menggunakan aplikasi ini.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-primary-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Satu akun hanya untuk satu pengguna dan tidak dapat dialihkan ke pihak lain.</span>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 bg-gradient-to-br from-green-400 to-green-500 rounded-full inline-block"></span>
                    Privasi Data
                </h2>
                <p class="text-gray-600 leading-relaxed mb-3">
                    Kami berkomitmen untuk melindungi privasi dan data pribadi Anda. Pengumpulan dan penggunaan data pribadi diatur dalam Kebijakan Privasi kami. Data kesehatan yang Anda masukkan ke dalam aplikasi bersifat rahasia dan hanya dapat diakses oleh Anda.
                </p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Data Anda tidak akan dijual atau dibagikan kepada pihak ketiga tanpa izin tertulis dari Anda.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Komunikasi data menggunakan enkripsi standar industri (SSL/TLS).</span>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 bg-gradient-to-br from-red-400 to-red-500 rounded-full inline-block"></span>
                    Disclaimer Medis
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    <strong>SIMANIS BUKAN perangkat medis dan TIDAK memberikan diagnosis medis.</strong> Seluruh informasi yang disediakan dalam aplikasi ini bersifat edukatif dan informatif. Aplikasi ini tidak dimaksudkan untuk menggantikan saran, diagnosis, atau pengobatan dari dokter atau tenaga kesehatan profesional.
                </p>
                <ul class="space-y-2 text-gray-600 mt-3">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Selalu konsultasikan dengan dokter Anda sebelum mengambil keputusan medis berdasarkan informasi dari aplikasi ini.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-500 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Dalam keadaan darurat medis, segera hubungi layanan gawat darurat atau kunjungi fasilitas kesehatan terdekat.</span>
                    </li>
                </ul>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-full inline-block"></span>
                    Batasan Tanggung Jawab
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    SIMANIS dan pengembangnya tidak bertanggung jawab atas kerugian langsung, tidak langsung, insidental, atau konsekuensial yang timbul dari penggunaan atau ketidakmampuan menggunakan aplikasi. Kami tidak menjamin bahwa aplikasi akan bebas dari kesalahan, gangguan, atau tersedia setiap saat.
                </p>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 bg-gradient-to-br from-amber-400 to-amber-500 rounded-full inline-block"></span>
                    Perubahan Ketentuan
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Kami berhak untuk mengubah atau memperbarui Syarat & Ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya. Perubahan akan efektif segera setelah dipublikasikan di aplikasi. Penggunaan berkelanjutan dari aplikasi setelah perubahan tersebut merupakan persetujuan Anda terhadap ketentuan yang telah diubah.
                </p>
            </div>

            <div class="card">
                <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <span class="w-1 h-5 gradient-primary rounded-full inline-block"></span>
                    Kontak
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Jika Anda memiliki pertanyaan tentang Syarat & Ketentuan ini, silakan hubungi kami melalui halaman <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-700 font-medium underline">Kontak</a>.
                </p>
            </div>

            <div class="flex justify-center pt-4">
                <a href="{{ route('login') }}" class="btn-white inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
