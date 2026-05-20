@extends('layouts.app')

@section('title', 'Opsi: ' . $subGroup->title)
@section('page-title', 'Opsi Penilaian')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 flex items-center gap-2 text-sm text-gray-400">
        <a href="{{ route('admin.assessments.index') }}" class="hover:text-primary-600 transition-colors">Kelompok</a>
        <span>/</span>
        <span class="text-gray-600 font-medium">{{ $group->title }}</span>
        <span>/</span>
        <span class="text-gray-800 font-medium">{{ $subGroup->title }}</span>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Opsi: {{ $subGroup->title }}</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola opsi penilaian untuk sub-kelompok ini</p>
        </div>
        <a href="{{ route('admin.assessments.options.create', [$group->id, $subGroup->id]) }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Opsi
        </a>
    </div>

    @if($options->isEmpty())
        <div class="card text-center py-12">
            <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada opsi</h3>
            <p class="text-sm text-gray-400">Tambahkan opsi penilaian untuk sub-kelompok ini</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($options as $option)
            <div class="card">
                <div class="flex items-start gap-4">
                    @if($option->image)
                        <img src="{{ asset('storage/' . $option->image) }}" alt="{{ $option->text }}" class="w-16 h-16 rounded-xl object-cover flex-shrink-0 border border-gray-200">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-800 font-medium">{{ $option->text }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="badge badge-pink text-xs">Skor: {{ $option->score }}</span>
                            <span class="text-xs text-gray-400">Urutan: {{ $option->order }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <a href="{{ route('admin.assessments.options.edit', [$group->id, $subGroup->id, $option->id]) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.assessments.options.destroy', [$group->id, $subGroup->id, $option->id]) }}" method="POST" onsubmit="return confirm('Hapus opsi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
