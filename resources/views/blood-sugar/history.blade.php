@extends('layouts.app')

@section('title', 'Riwayat Gula Darah')
@section('page-title', 'Riwayat Pemeriksaan Gula Darah')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Chart Card -->
    @if($chartData->count() > 0)
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Tren Gula Darah (30 Pemeriksaan Terakhir)</h3>
        <div class="w-full" style="height: 280px;">
            <canvas id="bloodSugarChart"></canvas>
        </div>
    </div>
    @endif

    <!-- Filter & Summary -->
    <div class="card">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-pink-500 flex items-center justify-center shadow-lg shadow-primary-500/30">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-800">Riwayat Pemeriksaan</h3>
                    <p class="text-xs text-gray-400">Total {{ $records->total() }} catatan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('blood-sugar.history') }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ !$filterType ? 'bg-primary-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                <a href="{{ route('blood-sugar.history', ['type' => 'GDP']) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ $filterType === 'GDP' ? 'bg-primary-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    GDP
                </a>
                <a href="{{ route('blood-sugar.history', ['type' => 'GDS']) }}" class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 {{ $filterType === 'GDS' ? 'bg-pink-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    GDS
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card overflow-hidden !p-0">
        @if($records->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Tipe</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Nilai</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Kategori</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Catatan</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($records as $record)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            @if($record->type === 'GDP')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary-100 text-primary-700">GDP</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-700">GDS</span>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-semibold text-gray-800">{{ $record->value }}</span>
                            <span class="text-gray-400 text-xs ml-0.5">mg/dL</span>
                        </td>
                        <td class="px-5 py-4">
                            @php
                                $catColor = match($record->category) {
                                    'Normal' => 'bg-green-100 text-green-700',
                                    'Tinggi' => 'bg-yellow-100 text-yellow-700',
                                    'Sangat Tinggi' => 'bg-red-100 text-red-700',
                                    'Rendah' => 'bg-orange-100 text-orange-700',
                                    'Sangat Rendah' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $catColor }}">{{ $record->category }}</span>
                        </td>
                        <td class="px-5 py-4 text-gray-500 max-w-[200px] truncate">
                            {{ $record->notes ?? '-' }}
                        </td>
                        <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                            {{ $record->recorded_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $records->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada catatan pemeriksaan</p>
            <p class="text-gray-400 text-sm mt-1">Hasil pemeriksaan yang disimpan akan muncul di sini</p>
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
@if($chartData->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    const ctx = document.getElementById('bloodSugarChart').getContext('2d');

    const labels = {!! json_encode($chartData->pluck('recorded_at')->map(fn($d) => $d->format('d/m H:i'))) !!};
    const values = {!! json_encode($chartData->pluck('value')) !!};
    const types = {!! json_encode($chartData->pluck('type')) !!};

    const gdpColor = '#4f46e5';
    const gdsColor = '#ec4899';

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gula Darah (mg/dL)',
                data: values,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.08)',
                pointBackgroundColor: types.map(t => t === 'GDP' ? gdpColor : gdsColor),
                pointBorderColor: types.map(t => t === 'GDP' ? gdpColor : gdsColor),
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.parsed.y + ' mg/dL';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { callback: function(v) { return v + ' mg/dL'; } }
                },
                x: {
                    grid: { display: false },
                    ticks: { maxRotation: 45, font: { size: 10 } }
                }
            }
        }
    });
})();
</script>
@endif
@endpush
