@extends('layouts.app')

@section('title', isset($group) && $group->id ? 'Edit Kelompok' : 'Tambah Kelompok')
@section('page-title', isset($group) && $group->id ? 'Edit Kelompok' : 'Tambah Kelompok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <form action="{{ isset($group) && $group->id ? route('admin.assessments.update', $group->id) : route('admin.assessments.store') }}" method="POST">
            @csrf
            @if(isset($group) && $group->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $group->title ?? '') }}"
                        placeholder="Contoh: Kulit Kaki"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="input-label">Slug <span class="text-gray-400 text-xs font-normal">(otomatis dari judul jika dikosongkan)</span></label>
                    <input type="text" name="slug" id="slug"
                        class="input-field @error('slug') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('slug', $group->slug ?? '') }}"
                        placeholder="kulit-kaki">
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Deskripsi kelompok penilaian...">{{ old('description', $group->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon" class="input-label">Icon (SVG inline)</label>
                    <input type="text" name="icon" id="icon"
                        class="input-field @error('icon') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('icon', $group->icon ?? '') }}"
                        placeholder="<svg ...>">
                    @error('icon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $group->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($group) && $group->id ? 'Simpan Perubahan' : 'Simpan Kelompok' }}
                </button>
                <a href="{{ route('admin.assessments.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
