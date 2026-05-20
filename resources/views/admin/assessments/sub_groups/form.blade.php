@extends('layouts.app')

@section('title', isset($subGroup) && $subGroup->id ? 'Edit Sub-Kelompok' : 'Tambah Sub-Kelompok')
@section('page-title', isset($subGroup) && $subGroup->id ? 'Edit Sub-Kelompok' : 'Tambah Sub-Kelompok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4 flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.assessments.index') }}" class="hover:text-primary-600 transition-colors">Kelompok</a>
        <span>/</span>
        <span class="text-gray-600 font-medium">{{ $group->title }}</span>
        <span>/</span>
        <span class="text-gray-800">{{ isset($subGroup) && $subGroup->id ? 'Edit' : 'Tambah' }} Sub-Kelompok</span>
    </div>

    <div class="card">
        <form action="{{ isset($subGroup) && $subGroup->id ? route('admin.assessments.sub-groups.update', [$group->id, $subGroup->id]) : route('admin.assessments.sub-groups.store', $group->id) }}" method="POST">
            @csrf
            @if(isset($subGroup) && $subGroup->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $subGroup->title ?? '') }}"
                        placeholder="Contoh: Kaki Kiri"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Deskripsi sub-kelompok...">{{ old('description', $subGroup->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $subGroup->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($subGroup) && $subGroup->id ? 'Simpan Perubahan' : 'Simpan Sub-Kelompok' }}
                </button>
                <a href="{{ route('admin.assessments.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
