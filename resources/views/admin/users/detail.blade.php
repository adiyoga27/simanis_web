@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.users') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Daftar
        </a>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            Edit Pengguna
        </a>
    </div>

    <div class="card">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <div class="w-24 h-24 rounded-full gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/30 shrink-0">
                <span class="text-4xl font-extrabold text-white">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-400">{{ '@' . $user->username }}</p>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2">
                    @if($user->role === 'admin')
                        <span class="badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Admin</span>
                    @else
                        <span class="badge inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">User</span>
                    @endif
                    @if($user->email_verified_at)
                        <span class="badge badge-green">Terverifikasi</span>
                    @else
                        <span class="badge badge-yellow">Belum Verifikasi</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Informasi Pribadi</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Email</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">No. Telepon</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->phone ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Tanggal Lahir</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->birthdate ? \Carbon\Carbon::parse($user->birthdate)->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Jenis Kelamin</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->jk == 'L' ? 'Laki-laki' : ($user->jk == 'P' ? 'Perempuan' : '-') }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Data Kesehatan</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Tinggi Badan</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->tall ? $user->tall . ' cm' : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Berat Badan</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->weight ? $user->weight . ' kg' : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-sm text-gray-500">Golongan Darah</span>
                    <span class="text-sm font-medium text-gray-800">{{ $user->blood ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm text-gray-500">Merokok</span>
                    <span class="text-sm font-medium {{ $user->is_smoke ? 'text-red-600' : 'text-green-600' }}">{{ $user->is_smoke ? 'Ya' : 'Tidak' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="flex items-center gap-3 mb-5">
            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
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
                <span class="text-sm font-medium text-gray-800">{{ $user->subdistrict ?? '-' }}</span>
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
                <span class="text-sm font-medium text-gray-800">{{ $user->kode_pos ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Data Kesehatan</h3>
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
            <div class="stat-card">
                <div class="stat-value text-red-500">{{ $bloodSugarCount }}</div>
                <div class="stat-label">Cek Gula Darah</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-pink-500">{{ $footScreeningCount }}</div>
                <div class="stat-label">Screening Kaki</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-green-600">{{ $tntCount }}</div>
                <div class="stat-label">TNT</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-yellow-600">{{ $medicationCount }}</div>
                <div class="stat-label">Jadwal Obat</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-blue-600">{{ $weightLogCount }}</div>
                <div class="stat-label">Berat Badan</div>
            </div>
            <div class="stat-card">
                <div class="stat-value text-indigo-600">{{ $assessmentCount }}</div>
                <div class="stat-label">Assessment</div>
            </div>
        </div>
    </div>

    @if($recentBloodSugar->count() > 0)
    <div class="card overflow-hidden !p-0">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Riwayat Gula Darah Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 font-semibold text-gray-600">Tipe</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Nilai</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Kategori</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentBloodSugar as $record)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            @if($record->type === 'GDP')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-primary-100 text-primary-700">GDP</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-pink-100 text-pink-700">GDS</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ $record->value }} <span class="text-gray-400 font-normal text-xs">mg/dL</span></td>
                        <td class="px-5 py-3">
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
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $catColor }}">{{ $record->category }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $record->recorded_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($recentFootScreening->count() > 0)
    <div class="card overflow-hidden !p-0">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Riwayat Screening Kaki Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 font-semibold text-gray-600">Skor</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Tingkat Risiko</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentFootScreening as $result)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ $result->score }}</td>
                        <td class="px-5 py-3">
                            @php
                                $riskColor = match($result->risk_level) {
                                    'Tinggi' => 'bg-red-100 text-red-700',
                                    'Ringan' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-green-100 text-green-700',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $riskColor }}">{{ $result->risk_level }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $result->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($recentAssessments->count() > 0)
    <div class="card overflow-hidden !p-0">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-800">Riwayat Assessment Kaki Diabetes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 font-semibold text-gray-600">Total Skor</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Aturan Cocok</th>
                        <th class="px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                        <th class="px-5 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentAssessments as $result)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            <span class="badge {{ $result->total_score > 6 ? 'badge-red' : ($result->total_score > 3 ? 'badge-yellow' : 'badge-green') }}">
                                {{ $result->total_score }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ is_array($result->matched_rules) ? count($result->matched_rules) : 0 }} aturan</td>
                        <td class="px-5 py-3 text-gray-500 whitespace-nowrap">{{ $result->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('admin.assessments.result.detail', [$user->id, $result->id]) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
