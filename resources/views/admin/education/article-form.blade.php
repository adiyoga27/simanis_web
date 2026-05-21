@extends('layouts.app')

@section('title', isset($education->id) ? 'Edit Artikel' : 'Tambah Artikel')
@section('page-title', isset($education->id) ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        <p class="text-sm text-gray-400 mb-4">Kategori: <strong>{{ $category->title }}</strong></p>

        <form action="{{ isset($education->id) ? route('admin.education.articles.update', $education->id) : route('admin.education.articles.store', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($education->id)) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="input-field @error('title') border-red-300 @enderror" value="{{ old('title', $education->title ?? '') }}" required>
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="input-label">Gambar</label>
                    @if(!empty($education->image))
                        <img src="{{ asset('storage/' . $education->image) }}" class="w-32 h-20 rounded-lg object-cover mb-2">
                    @endif
                    <input type="file" name="image" class="input-field" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Max 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
                </div>

                <div>
                    <label class="input-label">Konten <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="12" class="input-field @error('content') border-red-300 @enderror" required>{{ old('content', $education->content ?? '') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">HTML diperbolehkan.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">Simpan</button>
                <a href="{{ route('admin.education.articles', $category->id) }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
