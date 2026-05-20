@extends('layouts.app')

@section('title', isset($option) && $option->id ? 'Edit Opsi' : 'Tambah Opsi')
@section('page-title', isset($option) && $option->id ? 'Edit Opsi' : 'Tambah Opsi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4 flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.assessments.index') }}" class="hover:text-primary-600 transition-colors">Kelompok</a>
        <span>/</span>
        <span class="text-gray-600 font-medium">{{ $group->title }}</span>
        <span>/</span>
        <a href="{{ route('admin.assessments.options.index', [$group->id, $subGroup->id]) }}" class="hover:text-primary-600 transition-colors">{{ $subGroup->title }}</a>
        <span>/</span>
        <span class="text-gray-800">{{ isset($option) && $option->id ? 'Edit' : 'Tambah' }} Opsi</span>
    </div>

    <div class="card">
        <form action="{{ isset($option) && $option->id ? route('admin.assessments.options.update', [$group->id, $subGroup->id, $option->id]) : route('admin.assessments.options.store', [$group->id, $subGroup->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($option) && $option->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="text" class="input-label">Teks Opsi <span class="text-red-500">*</span></label>
                    <textarea name="text" id="text" rows="2"
                        class="input-field @error('text') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Contoh: Kulit normal, tidak ada perubahan"
                        required>{{ old('text', $option->text ?? '') }}</textarea>
                    @error('text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="input-label">Gambar</label>
                    @if(isset($option) && $option->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $option->image) }}" alt="Preview" class="w-24 h-24 rounded-xl object-cover border border-gray-200">
                            <p class="text-xs text-gray-400 mt-1">{{ $option->image }}</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image"
                        class="input-field @error('image') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, GIF, WebP. Maks: 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="score" class="input-label">Skor <span class="text-red-500">*</span></label>
                    <input type="number" name="score" id="score"
                        class="input-field @error('score') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('score', $option->score ?? 0) }}"
                        min="0"
                        required>
                    @error('score')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $option->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($option) && $option->id ? 'Simpan Perubahan' : 'Simpan Opsi' }}
                </button>
                <a href="{{ route('admin.assessments.options.index', [$group->id, $subGroup->id]) }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
