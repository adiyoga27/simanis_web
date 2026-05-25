@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-800">Daftar Pengguna</h3>
                <p class="text-xs text-gray-400">Total {{ $users->total() }} pengguna</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </a>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <form method="GET" action="{{ route('admin.users') }}" class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan nama, email, atau username..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary-400 focus:ring-2 focus:ring-primary-400/20 outline-none transition-all duration-300">
        </form>
    </div>

    <div class="card overflow-hidden !p-0">
        @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Nama</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Email</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Username</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Role</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Verifikasi</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Terdaftar</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center text-white font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500">{{ $user->email }}</td>
                        <td class="px-5 py-4 text-gray-500">{{ $user->username }}</td>
                        <td class="px-5 py-4">
                            @php
                                $roleColors = [
                                    'superadmin' => 'bg-purple-100 text-purple-700',
                                    'kepala_puskesmas' => 'bg-blue-100 text-blue-700',
                                    'kepala_desa' => 'bg-green-100 text-green-700',
                                    'kader' => 'bg-orange-100 text-orange-700',
                                    'pasien' => 'bg-gray-100 text-gray-600',
                                ];
                                $roleLabels = [
                                    'superadmin' => 'Superadmin',
                                    'kepala_puskesmas' => 'Kepala Puskesmas',
                                    'kepala_desa' => 'Kepala Desa',
                                    'kader' => 'Kader',
                                    'pasien' => 'Pasien',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $roleLabels[$user->role] ?? 'User' }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Terverifikasi</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Belum</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-gray-500 whitespace-nowrap">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.detail', $user->id) }}" class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @else
        <div class="py-16 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada data pengguna</p>
            <p class="text-gray-400 text-sm mt-1">
                @if($search)
                    Tidak ditemukan pengguna dengan kata kunci "{{ $search }}"
                @else
                    Belum ada pengguna terdaftar
                @endif
            </p>
        </div>
        @endif
    </div>

</div>
@endsection
