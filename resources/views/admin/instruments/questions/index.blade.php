@extends('layouts.app')

@section('title', 'Pertanyaan Instrumen')
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
            <h2 class="text-xl font-bold text-gray-800">Pertanyaan</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola daftar pertanyaan instrument keyakinan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.instruments.results') }}" class="btn-white text-sm">Hasil User</a>
            <a href="{{ route('admin.instruments.questions.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah
            </a>
        </div>
    </div>

    @if($questions->isEmpty())
        <div class="card text-center py-16 text-gray-400">Belum ada pertanyaan.</div>
    @else
        <div class="space-y-3">
            @foreach($questions as $q)
            <div class="card flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="text-xs font-mono text-gray-400 bg-gray-100 px-2 py-1 rounded">#{{ $q->order }}</span>
                    <p class="text-sm text-gray-700">{{ $q->question }}</p>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.instruments.questions.edit', $q->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.instruments.questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
