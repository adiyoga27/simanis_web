@extends('layouts.app')

@section('title', 'Berat Badan')
@section('page-title', 'Pemantauan Berat Badan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if (session('success'))
        <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="card text-center">
            <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center shadow-lg shadow-primary-400/30 mb-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" /></svg>
            </div>
            <p class="stat-value">{{ $user->weight }} <span class="text-lg font-normal text-gray-400">kg</span></p>
            <p class="stat-label">Berat Saat Ini</p>
        </div>
        <div class="card text-center">
            <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center shadow-lg shadow-green-400/30 mb-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
            </div>
            <p class="stat-value">{{ $user->tall }} <span class="text-lg font-normal text-gray-400">cm</span></p>
            <p class="stat-label">Tinggi</p>
        </div>
        <div class="card text-center">
            <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg shadow-amber-400/30 mb-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <p class="stat-value">{{ $currentBmi ?? '-' }}</p>
            <p class="stat-label">
                BMI
                @if ($currentBmi)
                    @if ($currentBmi < 18.5) <span class="badge-yellow text-xs">Kurus</span>
                    @elseif ($currentBmi < 25) <span class="badge-green text-xs">Normal</span>
                    @elseif ($currentBmi < 30) <span class="badge-yellow text-xs">Berlebih</span>
                    @else <span class="badge-red text-xs">Obesitas</span>
                    @endif
                @endif
            </p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 gradient-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Catat Berat Badan</h2>
                <p class="text-sm text-gray-400">Pantau perubahan berat badan Anda secara berkala</p>
            </div>
        </div>

        <form action="{{ route('weight.save') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="weight" class="input-label">Berat Badan (kg) <span class="text-red-400">*</span></label>
                    <input type="number" name="weight" id="weight" class="input-field @error('weight') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('weight') }}" placeholder="Contoh: 65" min="20" max="500" step="0.1" required>
                    @error('weight')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tall" class="input-label">Tinggi Badan (cm) <span class="text-gray-300 text-xs">opsional</span></label>
                    <input type="number" name="tall" id="tall" class="input-field @error('tall') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('tall', $user->tall) }}" placeholder="Contoh: 165" min="50" max="300">
                    @error('tall')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="recorded_at" class="input-label">Tanggal <span class="text-red-400">*</span></label>
                    <input type="date" name="recorded_at" id="recorded_at" class="input-field @error('recorded_at') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('recorded_at', date('Y-m-d')) }}" required>
                    @error('recorded_at')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="notes" class="input-label">Catatan <span class="text-gray-300 text-xs">opsional</span></label>
                    <input type="text" name="notes" id="notes" class="input-field @error('notes') border-red-400 focus:border-red-400 focus:ring-red-400/20 @enderror" value="{{ old('notes') }}" placeholder="Contoh: Setelah olahraga pagi" maxlength="500">
                    @error('notes')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
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
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <!-- Trend Chart -->
    @if ($logs->count() > 0)
    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Berat Badan</h3>
        @php
            $chartLogs = $logs->sortBy('recorded_at')->values();
            $maxWeight = $chartLogs->max('weight');
            $minWeight = $chartLogs->min('weight');
            $range = $maxWeight - $minWeight ?: 1;
        @endphp
        <div class="flex items-end gap-2 h-48 px-2">
            @foreach ($chartLogs as $log)
                @php
                    $heightPct = (($log->weight - $minWeight) / $range) * 70 + 15;
                @endphp
                <div class="flex-1 flex flex-col items-center justify-end h-full group">
                    <span class="text-xs font-semibold text-gray-700 mb-1">{{ $log->weight }}</span>
                    <div class="w-full rounded-t-lg bg-gradient-to-t from-pink-400 to-primary-400 group-hover:from-pink-500 group-hover:to-primary-500 transition-colors" style="height: {{ $heightPct }}%"></div>
                    <span class="text-[10px] text-gray-400 mt-1 truncate w-full text-center">{{ \Carbon\Carbon::parse($log->recorded_at)->format('d/m') }}</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- History Table -->
    <div class="card">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Riwayat Pencatatan
        </h3>

        @if ($logs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-2 text-gray-500 font-medium">Tanggal</th>
                            <th class="text-right py-3 px-2 text-gray-500 font-medium">Berat (kg)</th>
                            <th class="text-right py-3 px-2 text-gray-500 font-medium hidden sm:table-cell">Tinggi (cm)</th>
                            <th class="text-right py-3 px-2 text-gray-500 font-medium hidden sm:table-cell">BMI</th>
                            <th class="text-right py-3 px-2 text-gray-500 font-medium">Perubahan</th>
                            <th class="text-left py-3 px-2 text-gray-500 font-medium hidden md:table-cell">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                <td class="py-3 px-2 font-medium text-gray-700">
                                    {{ \Carbon\Carbon::parse($log->recorded_at)->format('d M Y') }}
                                </td>
                                <td class="py-3 px-2 text-right font-semibold text-gray-800">{{ $log->weight }}</td>
                                <td class="py-3 px-2 text-right text-gray-600 hidden sm:table-cell">{{ $log->tall ?? '-' }}</td>
                                <td class="py-3 px-2 text-right font-medium hidden sm:table-cell">
                                    @if ($log->bmi_value)
                                        <span @class([
                                            'inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold',
                                            'bg-yellow-100 text-yellow-700' => $log->bmi_value < 18.5,
                                            'bg-green-100 text-green-700' => $log->bmi_value >= 18.5 && $log->bmi_value < 25,
                                            'bg-yellow-100 text-yellow-700' => $log->bmi_value >= 25 && $log->bmi_value < 30,
                                            'bg-red-100 text-red-700' => $log->bmi_value >= 30,
                                        ])>
                                            {{ $log->bmi_value }}
                                        </span>
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-2 text-right">
                                    @if ($log->change === null)
                                        <span class="text-gray-300 text-xs">-</span>
                                    @elseif ($log->change > 0)
                                        <span class="text-red-500 font-medium flex items-center justify-end gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                                            +{{ $log->change }}
                                        </span>
                                    @elseif ($log->change < 0)
                                        <span class="text-green-500 font-medium flex items-center justify-end gap-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            {{ $log->change }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">0</span>
                                    @endif
                                </td>
                                <td class="py-3 px-2 text-gray-500 hidden md:table-cell max-w-[200px] truncate">
                                    {{ $log->notes ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h1m16 0h1M5.5 5.5l.7.7m11.6 11.6l.7.7M5.5 18.5l.7-.7m11.6-11.6l.7-.7M12 3v1m0 16v1M8.5 6.5a3.5 3.5 0 107 0 3.5 3.5 0 00-7 0zm7 7a3.5 3.5 0 10-7 0 3.5 3.5 0 007 0z" /></svg>
                <p class="font-medium">Belum ada data pencatatan</p>
                <p class="text-xs mt-1">Gunakan form di atas untuk mencatat berat badan Anda.</p>
            </div>
        @endif
    </div>

    <!-- Info Card -->
    <div class="card border-l-4 border-l-pink-400">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div class="space-y-3">
                <h3 class="text-lg font-bold text-gray-800">Mengapa Memantau Berat Badan?</h3>
                <div class="text-sm text-gray-600 leading-relaxed space-y-2">
                    <p>Pemantauan berat badan secara rutin sangat penting bagi penderita diabetes karena:</p>
                    <ul class="list-disc list-inside space-y-1 ml-2">
                        <li>Berat badan ideal membantu meningkatkan sensitivitas insulin</li>
                        <li>Penurunan berat badan 5-10% dapat menurunkan kadar gula darah secara signifikan</li>
                        <li>Membantu mengidentifikasi pola perubahan berat badan</li>
                        <li>Mendukung evaluasi efektivitas terapi nutrisi dan aktivitas fisik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
