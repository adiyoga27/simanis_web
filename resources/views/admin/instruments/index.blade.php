@extends('layouts.app')

@section('title', 'Instrument Keyakinan')
@section('page-title', 'Instrument Keyakinan')

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
            <h2 class="text-xl font-bold text-gray-800">Instrument Keyakinan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola grup & pertanyaan instrument keyakinan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.instruments.results') }}" class="btn-white text-sm">Hasil User</a>
            <button onclick="document.getElementById('addGroupForm').classList.toggle('hidden')" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Grup
            </button>
        </div>
    </div>

    {{-- Add Group Form --}}
    <div id="addGroupForm" class="card hidden">
        <form action="{{ route('admin.instruments.groups.store') }}" method="POST" class="flex items-end gap-3">
            @csrf
            <div class="flex-1">
                <label class="input-label">Judul Grup</label>
                <input type="text" name="title" class="input-field" placeholder="Nama grup..." required>
            </div>
            <div class="w-24">
                <label class="input-label">Urutan</label>
                <input type="number" name="order" class="input-field" value="0" min="0">
            </div>
            <button type="submit" class="btn-primary">Simpan</button>
        </form>
    </div>

    @if($groups->isEmpty())
        <div class="card text-center py-16 text-gray-400">Belum ada grup.</div>
    @else
        <div class="space-y-4">
            @foreach($groups as $group)
            <div class="card">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <span class="text-xs text-gray-400 font-mono bg-gray-100 px-2 py-0.5 rounded mr-2">#{{ $group->order }}</span>
                        <span class="font-semibold text-gray-800">{{ $group->title }}</span>
                        <span class="text-xs text-gray-400 ml-2">{{ $group->questions->count() }} pertanyaan</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <button onclick="document.getElementById('editGroup{{ $group->id }}').classList.toggle('hidden')" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <form action="{{ route('admin.instruments.groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Hapus grup beserta pertanyaan?')">
                            @csrf @method('DELETE')
                            <button class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Edit Group --}}
                <div id="editGroup{{ $group->id }}" class="hidden mb-4 p-4 bg-gray-50 rounded-xl">
                    <form action="{{ route('admin.instruments.groups.update', $group->id) }}" method="POST" class="flex items-end gap-3">
                        @csrf @method('PUT')
                        <input type="text" name="title" class="input-field flex-1" value="{{ $group->title }}" required>
                        <input type="number" name="order" class="input-field w-20" value="{{ $group->order }}" min="0">
                        <button type="submit" class="btn-primary text-sm">Update</button>
                    </form>
                </div>

                {{-- Questions list --}}
                <div class="space-y-1">
                    @foreach($group->questions as $q)
                    <div class="flex items-center justify-between text-sm py-1.5 px-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-600">{{ $q->question }}</span>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.instruments.questions.edit', $q->id) }}" class="p-1 text-gray-400 hover:text-primary-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.instruments.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="p-1 text-gray-400 hover:text-red-600"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <a href="{{ route('admin.instruments.questions.create', $group->id) }}" class="inline-flex items-center gap-1 text-xs font-medium text-primary-600 hover:text-primary-700 mt-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Pertanyaan
                </a>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
