@extends('layouts.app')

@section('title', 'Data Master Edukasi')
@section('page-title', 'Data Master Edukasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Kategori Edukasi</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola kategori & artikel edukasi</p>
        </div>
        <button onclick="document.getElementById('addForm').classList.toggle('hidden')" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </button>
    </div>

    <div id="addForm" class="card hidden">
        <form action="{{ route('admin.education.categories.store') }}" method="POST" class="flex items-end gap-3">
            @csrf
            <div class="flex-1">
                <label class="input-label">Judul</label>
                <input type="text" name="title" class="input-field" placeholder="Nama kategori..." required>
            </div>
            <button type="submit" class="btn-primary">Simpan</button>
        </form>
    </div>

    @if($categories->isEmpty())
        <div class="card text-center py-16 text-gray-400">Belum ada kategori.</div>
    @else
        <div class="space-y-4">
            @foreach($categories as $cat)
            <div class="card">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <span class="font-semibold text-gray-800">{{ $cat->title }}</span>
                        <span class="text-xs text-gray-400 ml-2">{{ $cat->educations_count }} artikel</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="document.getElementById('edit{{ $cat->id }}').classList.toggle('hidden')" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('admin.education.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori & artikelnya?')">
                            @csrf @method('DELETE')
                            <button class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div id="edit{{ $cat->id }}" class="hidden mb-3 p-4 bg-gray-50 rounded-xl">
                    <form action="{{ route('admin.education.categories.update', $cat->id) }}" method="POST" class="flex items-end gap-3">
                        @csrf @method('PUT')
                        <input type="text" name="title" class="input-field flex-1" value="{{ $cat->title }}" required>
                        <button type="submit" class="btn-primary text-sm">Update</button>
                    </form>
                </div>

                <a href="{{ route('admin.education.articles', $cat->id) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                    Kelola Artikel &rarr;
                </a>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
