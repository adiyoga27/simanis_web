@extends('layouts.app')

@section('title', 'Pilih Pasien')
@section('page-title', 'Pilih Pasien untuk Input Data')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <form method="GET">
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari pasien berdasarkan nama..." class="input-field">
    </form>

    <div class="card">
        @if($pasienUsers->isEmpty())
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13.5 7a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada pasien</p>
            <p class="text-gray-400 text-sm mt-1">Belum ada pasien terdaftar dalam sistem.</p>
        </div>
        @else
        <div class="divide-y divide-gray-100">
            @foreach($pasienUsers as $p)
            <form method="POST" action="{{ route('admin.data-entry.select') }}" class="block">
                @csrf
                <input type="hidden" name="user_id" value="{{ $p->id }}">
                <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">
                <button type="submit" class="w-full text-left px-1 py-4 hover:bg-gray-50 transition-colors flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-400 to-pink-400 flex items-center justify-center text-white font-bold shrink-0">
                        {{ strtoupper(substr($p->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-gray-800">{{ $p->name }}</p>
                        <p class="text-sm text-gray-400">{{ $p->address ?: '—' }}</p>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>
            @endforeach
        </div>
        @endif
    </div>

    <div class="text-center">
        <a href="{{ $backUrl }}" class="text-sm text-gray-400 hover:text-primary-600 transition-colors">
            &larr; Kembali ke Monitoring
        </a>
    </div>

</div>
@endsection
