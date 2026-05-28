@extends('layouts.app')

@section('title', isset($group) && $group->id ? 'Edit Kelompok' : 'Tambah Kelompok')
@section('page-title', isset($group) && $group->id ? 'Edit Kelompok' : 'Tambah Kelompok')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <form action="{{ isset($group) && $group->id ? route('admin.assessments.update', $group->id) : route('admin.assessments.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="image" class="input-label">Thumbnail Gambar</label>
                    @if(!empty($group->image))
                        <img src="{{ asset('storage/' . $group->image) }}" alt="Thumbnail" class="w-full max-w-xs rounded-xl object-cover mb-2 border border-gray-200">
                    @endif
                    <label class="flex flex-col items-center justify-center gap-2 p-6 rounded-2xl border-2 border-dashed border-gray-200 hover:border-primary-300 hover:bg-primary-50/30 cursor-pointer transition-all duration-200">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-400">JPG, PNG, WebP (max 2MB)</p>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                    </label>
                    @error('image')
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

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function() {
        const label = this.parentElement;
        if (this.files.length) {
            label.querySelector('p:first-of-type').textContent = this.files[0].name;
        }
    });
</script>
@endpush
@endsection
