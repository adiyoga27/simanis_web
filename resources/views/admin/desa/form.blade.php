@extends('layouts.app')

@section('title', isset($desa) && $desa->id ? 'Edit Desa' : 'Tambah Desa')
@section('page-title', isset($desa) && $desa->id ? 'Edit Desa' : 'Tambah Desa')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="card">
        <form action="{{ isset($desa) && $desa->id ? route('admin.desa.update', $desa->id) : route('admin.desa.store') }}" method="POST">
            @csrf
            @if(isset($desa) && $desa->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="name" class="input-label">Nama Desa <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                        class="input-field @error('name') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('name', $desa->name ?? '') }}"
                        placeholder="Masukkan nama desa"
                        required autofocus>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="input-label">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                        class="input-field @error('address') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Masukkan alamat desa">{{ old('address', $desa->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($desa) && $desa->id ? 'Simpan Perubahan' : 'Simpan Desa' }}
                </button>
                <a href="{{ route('admin.desa.index') }}" class="btn-white flex-1 text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
