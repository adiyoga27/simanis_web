@extends('layouts.app')

@section('title', $record ?? false ? 'Edit Farmakologi' : 'Input Farmakologi')
@section('page-title', $record ?? false ? 'Edit Farmakologi' : 'Input Farmakologi')

@section('content')
<style>
.glass-card {
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.55);
    box-shadow: 0 8px 32px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.03);
}
.bg-mesh-teal {
    background:
        radial-gradient(at 0% 0%, rgba(20,184,166,0.07) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(6,182,212,0.07) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(59,130,246,0.05) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(16,185,129,0.05) 0px, transparent 50%);
}
.input-modern {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
}
.input-modern:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.08);
    outline: none;
}
.select-modern {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.2em 1.2em;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.select-modern:focus {
    border-color: #14b8a6;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.08);
    outline: none;
}
.btn-gradient-teal {
    background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 100%);
    transition: all 0.3s ease;
}
.btn-gradient-teal:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(20, 184, 166, 0.35);
}
</style>

<div class="max-w-2xl mx-auto space-y-6 pb-8">

    <div class="glass-card rounded-3xl p-6 sm:p-8 bg-mesh-teal">
        <div class="flex items-center gap-4">
            <div class="shrink-0 w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-teal-500/25">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.5 20.5l10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/>
                    <path d="M8.5 8.5l7 7"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $record ?? false ? 'Edit Data Farmakologi' : 'Input Data Farmakologi' }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">Catat obat yang diminum pasien</p>
            </div>
        </div>
    </div>

    <form action="{{ $record ?? false ? route('admin.pharmacology.update', $record->id) : route('admin.pharmacology.store') }}" method="POST" class="glass-card rounded-3xl p-6 sm:p-8 space-y-5">
        @csrf
        @if($record ?? false) @method('PUT') @endif

        {{-- Pasien --}}
        @if($patient ?? false)
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pasien</label>
                <div class="flex items-center gap-3 px-4 py-3.5 rounded-2xl bg-teal-50 border border-teal-100">
                    <div class="w-8 h-8 rounded-lg bg-teal-100 flex items-center justify-center text-xs font-extrabold text-teal-700 flex-shrink-0">
                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800">{{ $patient->name }}</p>
                        <p class="text-[11px] text-gray-400">{{ $patient->desa?->name ?? '-' }}</p>
                    </div>
                </div>
                <input type="hidden" name="user_id" value="{{ $patient->id }}">
            </div>
        @else
            <div>
                <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">Pasien <span class="text-red-500">*</span></label>
                <select name="user_id" id="user_id" required class="select-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 cursor-pointer">
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('user_id', $record->user_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('user_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        @endif

        {{-- Judul Obat --}}
        <div>
            <label for="medication_title" class="block text-sm font-bold text-gray-700 mb-2">Judul Obat <span class="text-red-500">*</span></label>
            <input type="text" name="medication_title" id="medication_title" value="{{ old('medication_title', $record->medication_title ?? '') }}" required class="input-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400" placeholder="Contoh: Metformin 500mg">
            @error('medication_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi (opsional)</label>
            <textarea name="description" id="description" rows="3" class="input-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400 resize-none" placeholder="Catatan tentang obat...">{{ old('description', $record->description ?? '') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Dosis Perhari --}}
        <div>
            <label for="daily_dose" class="block text-sm font-bold text-gray-700 mb-2">Dosis Perhari <span class="text-red-500">*</span></label>
            <input type="text" name="daily_dose" id="daily_dose" value="{{ old('daily_dose', $record->daily_dose ?? '') }}" required class="input-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400" placeholder="Contoh: 2x1 tablet setelah makan">
            @error('daily_dose')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {{-- Tanggal Mulai --}}
            <div>
                <label for="start_date" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai Minum <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $record->start_date ?? '') }}" required class="input-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700">
                @error('start_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Waktu Mulai --}}
            <div>
                <label for="start_time" class="block text-sm font-bold text-gray-700 mb-2">Waktu Mulai Minum</label>
                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $record->start_time ?? '') }}" class="input-modern w-full px-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700">
                @error('start_time')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('admin.pharmacology.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-2xl bg-gray-100 text-gray-600 text-sm font-semibold hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit" class="btn-gradient-teal flex-1 inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-6 py-3.5 shadow-lg shadow-teal-500/25">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                {{ $record ?? false ? 'Simpan Perubahan' : 'Simpan Data' }}
            </button>
        </div>
    </form>

</div>
@endsection