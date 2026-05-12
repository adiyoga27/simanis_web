@extends('layouts.app')

@section('title', 'Hasil TNT')
@section('page-title', 'Hasil Terapi Nutrisi')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    @php
        $bmiCategory = '';
        $bmiColor = '';
        $bmiGradient = '';

        if ($bmi < 18.5) {
            $bmiCategory = 'Kurus';
            $bmiColor = 'text-yellow-600';
            $bmiGradient = 'from-yellow-400 to-yellow-500';
            $bmiBadge = 'badge-yellow';
        } elseif ($bmi >= 18.5 && $bmi <= 24.9) {
            $bmiCategory = 'Normal';
            $bmiColor = 'text-green-600';
            $bmiGradient = 'from-green-400 to-green-500';
            $bmiBadge = 'badge-green';
        } elseif ($bmi >= 25 && $bmi <= 29.9) {
            $bmiCategory = 'Gemuk';
            $bmiColor = 'text-orange-600';
            $bmiGradient = 'from-orange-400 to-orange-500';
            $bmiBadge = 'badge-yellow';
        } else {
            $bmiCategory = 'Obesitas';
            $bmiColor = 'text-red-600';
            $bmiGradient = 'from-red-400 to-red-500';
            $bmiBadge = 'badge-red';
        }
    @endphp

    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-pink rounded-xl flex items-center justify-center shadow-lg shadow-pink-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Hasil Perhitungan</h2>
                <p class="text-sm text-gray-400">Berikut hasil analisis kebutuhan nutrisi Anda</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex flex-col items-center p-4 rounded-2xl bg-gray-50/50">
                <p class="text-sm text-gray-500 mb-3">Indeks Massa Tubuh</p>
                <div class="w-28 h-28 rounded-full bg-gradient-to-br {{ $bmiGradient }} flex items-center justify-center shadow-lg mb-3">
                    <span class="text-3xl font-extrabold text-white">{{ number_format($bmi, 1) }}</span>
                </div>
                <span class="{{ $bmiBadge }}">{{ $bmiCategory }}</span>
            </div>

            <div class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gray-50/50">
                <p class="text-sm text-gray-500 mb-2">Berat Badan Ideal</p>
                <p class="text-4xl font-extrabold text-primary-600">{{ number_format($bbi, 1) }}</p>
                <p class="text-sm text-gray-400">kg</p>
            </div>

            <div class="flex flex-col items-center justify-center p-4 rounded-2xl bg-gradient-to-br from-primary-50 to-pink-50 border border-pink-100">
                <p class="text-sm text-gray-500 mb-2">Kebutuhan Kalori Harian</p>
                <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-pink-500">{{ number_format($calorieNeeds) }}</p>
                <p class="text-sm text-gray-400">kcal / hari</p>
            </div>
        </div>

        <div class="mt-6 p-4 rounded-xl bg-gray-50 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center text-sm">
            <div>
                <p class="text-gray-400">Jenis Kelamin</p>
                <p class="font-semibold text-gray-700">{{ $jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Tinggi Badan</p>
                <p class="font-semibold text-gray-700">{{ $height }} cm</p>
            </div>
            <div>
                <p class="text-gray-400">Berat Badan</p>
                <p class="font-semibold text-gray-700">{{ $weight }} kg</p>
            </div>
            <div>
                <p class="text-gray-400">Usia</p>
                <p class="font-semibold text-gray-700">{{ $age }} tahun</p>
            </div>
        </div>
    </div>

    @if (!empty($diets))
    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Rekomendasi Diet</h2>
                <p class="text-sm text-gray-400">{{ $diets->title }} — <span class="font-medium text-primary-600">{{ $diets->amount }}</span></p>
            </div>
        </div>

        @if (!empty($diets->times))
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($diets->times as $time)
            <div class="rounded-2xl border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="px-5 py-3 font-bold text-white text-sm
                    @if (stripos($time->name, 'Pagi') !== false)
                        gradient-primary
                    @elseif (stripos($time->name, 'Siang') !== false)
                        bg-gradient-to-br from-orange-400 to-orange-500
                    @elseif (stripos($time->name, 'Malam') !== false)
                        bg-gradient-to-br from-indigo-400 to-indigo-500
                    @else
                        gradient-pink
                    @endif
                ">
                    {{ $time->name }}
                </div>
                <div class="p-4 space-y-3">
                    @if (!empty($time->foods))
                        @foreach ($time->foods as $food)
                        <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">{{ $food->material ?? $food->menu ?? '' }}</p>
                                @if (!empty($food->unit))
                                    <p class="text-xs text-gray-400">{{ $food->unit }}</p>
                                @endif
                                @if (!empty($food->menu) && !empty($food->material))
                                    <p class="text-xs text-primary-500">{{ $food->menu }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-400 text-center py-2">Tidak ada data makanan</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endif

    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('tnt') }}" class="btn-white w-full sm:w-auto text-center">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </span>
        </a>
        <a href="{{ route('tnt') }}" class="btn-primary w-full sm:w-auto text-center">
            <span class="flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Hitung Ulang
            </span>
        </a>
    </div>
</div>
@endsection
