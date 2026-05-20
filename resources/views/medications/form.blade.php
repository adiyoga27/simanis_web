@extends('layouts.app')

@section('title', isset($medication) && $medication->id ? 'Edit Obat' : 'Tambah Obat')
@section('page-title', isset($medication) && $medication->id ? 'Edit Obat' : 'Tambah Obat')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="card">
        <form action="{{ isset($medication) && $medication->id ? route('medications.update', $medication->id) : route('medications.store') }}" method="POST">
            @csrf
            @if(isset($medication) && $medication->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Nama Obat <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $medication->title ?? '') }}"
                        placeholder="Contoh: Metformin 500mg"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="dosis" class="input-label">Dosis</label>
                    <input type="text" name="dosis" id="dosis"
                        class="input-field @error('dosis') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('dosis', $medication->dosis ?? '') }}"
                        placeholder="Contoh: 1 tablet (500mg)">
                    @error('dosis')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi / Catatan</label>
                    <textarea name="description" id="description" rows="3"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Informasi tambahan tentang obat ini...">{{ old('description', $medication->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="date_at" class="input-label">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="date_at" id="date_at"
                            class="input-field @error('date_at') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            value="{{ old('date_at', isset($medication->date_at) ? \Carbon\Carbon::parse($medication->date_at)->format('Y-m-d') : '') }}"
                            required>
                        @error('date_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    </div>

                    <div>
                        <label for="time_at" class="input-label">Waktu <span class="text-red-500">*</span></label>
                        <input type="time" name="time_at" id="time_at"
                            class="input-field @error('time_at') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            value="{{ old('time_at', $medication->time_at ?? '') }}"
                            required>
                        @error('time_at')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="duration" class="input-label">Durasi (menit)</label>
                    <input type="number" name="duration" id="duration"
                        class="input-field @error('duration') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('duration', $medication->duration ?? '') }}"
                        placeholder="Lama waktu konsumsi (opsional)"
                        min="1">
                    @error('duration')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        {{ old('is_active', $medication->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm font-medium text-gray-700 cursor-pointer">Aktifkan jadwal obat ini</label>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($medication) && $medication->id ? 'Simpan Perubahan' : 'Simpan Obat' }}
                </button>
                <a href="{{ route('medications.index') }}" class="btn-white flex-1 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
