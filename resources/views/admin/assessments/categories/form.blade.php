@extends('layouts.app')

@section('title', isset($category) && $category->id ? 'Edit Kategori Aturan' : 'Tambah Kategori Aturan')
@section('page-title', isset($category) && $category->id ? 'Edit Kategori Aturan' : 'Tambah Kategori Aturan')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="card">
        <form action="{{ isset($category) && $category->id ? route('admin.assessments.categories.update', $category->id) : route('admin.assessments.categories.store') }}" method="POST">
            @csrf
            @if(isset($category) && $category->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $category->title ?? '') }}"
                        placeholder="Contoh: Kondisi Kulit"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="input-label">Slug</label>
                    <input type="text" name="slug" id="slug"
                        class="input-field @error('slug') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('slug', $category->slug ?? '') }}"
                        placeholder="Auto-generated dari judul">
                    @error('slug')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="2"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Penjelasan singkat kategori...">{{ old('description', $category->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $category->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($category) && $category->id ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                </button>
                <a href="{{ route('admin.assessments.rules.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
