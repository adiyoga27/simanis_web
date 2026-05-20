@extends('layouts.app')

@section('title', 'Terapi Nutrisi (TNT)')
@section('page-title', 'Terapi Nutrisi (TNT)')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-800">Kalkulator Kebutuhan Kalori</h2>
                <p class="text-sm text-gray-400">Isi data diri untuk menghitung kebutuhan nutrisi harian Anda</p>
            </div>
            <a href="{{ route('tnt.history') }}" class="inline-flex items-center gap-1.5 text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors bg-primary-50 hover:bg-primary-100 px-3 py-2 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Riwayat
            </a>
        </div>

        <form action="{{ route('tnt.calculate') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jk" class="input-label">Jenis Kelamin</label>
                    <select name="jk" id="jk" class="input-field" required>
                        <option value="" disabled selected>Pilih jenis kelamin</option>
                        <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label for="height" class="input-label">Tinggi Badan (cm)</label>
                    <input type="number" name="height" id="height" class="input-field" placeholder="Contoh: 165" value="{{ old('height') }}" min="1" step="0.1" required>
                </div>

                <div>
                    <label for="weight" class="input-label">Berat Badan (kg)</label>
                    <input type="number" name="weight" id="weight" class="input-field" placeholder="Contoh: 60" value="{{ old('weight') }}" min="1" step="0.1" required>
                </div>

                <div>
                    <label for="age" class="input-label">Usia (tahun)</label>
                    <input type="number" name="age" id="age" class="input-field" placeholder="Contoh: 35" value="{{ old('age') }}" min="1" required>
                </div>

                <div>
                    <label for="activity" class="input-label">Aktivitas Fisik</label>
                    <select name="activity" id="activity" class="input-field" required>
                        <option value="" disabled selected>Pilih aktivitas fisik</option>
                        <option value="1" {{ old('activity') == '1' ? 'selected' : '' }}>Sangat Ringan (tiduran)</option>
                        <option value="2" {{ old('activity') == '2' ? 'selected' : '' }}>Ringan (duduk)</option>
                        <option value="3" {{ old('activity') == '3' ? 'selected' : '' }}>Sedang (guru/ibu RT)</option>
                        <option value="4" {{ old('activity') == '4' ? 'selected' : '' }}>Berat (olahragawan)</option>
                        <option value="5" {{ old('activity') == '5' ? 'selected' : '' }}>Sangat Berat (kuli)</option>
                    </select>
                </div>

                <div>
                    <label for="weight_status" class="input-label">Status Berat Badan</label>
                    <select name="weight_status" id="weight_status" class="input-field" required>
                        <option value="" disabled selected>Pilih status berat badan</option>
                        <option value="1" {{ old('weight_status') == '1' ? 'selected' : '' }}>Kelebihan Berat Badan</option>
                        <option value="2" {{ old('weight_status') == '2' ? 'selected' : '' }}>Normal / Ideal</option>
                        <option value="3" {{ old('weight_status') == '3' ? 'selected' : '' }}>Kekurangan Berat Badan</option>
                    </select>
                </div>
            </div>

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="flex justify-center pt-2">
                <button type="submit" class="btn-primary text-lg px-10 py-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Hitung Kebutuhan Kalori
                </button>
            </div>
        </form>
    </div>

    <div class="card border-l-4 border-l-pink-400">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-gray-800">Apa itu Terapi Nutrisi (TNT)?</h3>
                <div class="text-sm text-gray-600 leading-relaxed space-y-2">
                    <p>Terapi Nutrisi (TNT) adalah pengaturan pola makan yang bertujuan untuk membantu penderita diabetes mengontrol kadar gula darah melalui perhitungan kebutuhan kalori harian yang tepat.</p>
                    <p>Dengan mengetahui kebutuhan kalori harian Anda, Anda dapat mengatur porsi makan, memilih jenis makanan yang sesuai, dan menjaga berat badan ideal. Perhitungan ini mempertimbangkan:</p>
                    <ul class="list-disc list-inside space-y-1 ml-2">
                        <li><span class="font-medium text-primary-600">Jenis Kelamin</span> — kebutuhan kalori berbeda antara laki-laki dan perempuan</li>
                        <li><span class="font-medium text-primary-600">Tinggi & Berat Badan</span> — untuk menghitung BMI dan Berat Badan Ideal</li>
                        <li><span class="font-medium text-primary-600">Usia</span> — metabolisme melambat seiring bertambahnya usia</li>
                        <li><span class="font-medium text-primary-600">Aktivitas Fisik</span> — semakin aktif, semakin tinggi kebutuhan kalori</li>
                        <li><span class="font-medium text-primary-600">Status Berat Badan</span> — menentukan target kalori untuk mencapai berat ideal</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
