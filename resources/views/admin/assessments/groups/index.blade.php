@extends('layouts.app')

@section('title', 'Kelompok Penilaian')
@section('page-title', 'Kelompok Penilaian Kaki Diabetes')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Kelompok Penilaian</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola kelompok, sub-kelompok, dan opsi penilaian kaki diabetes</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.assessments.rules.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Aturan
            </a>
            <a href="{{ route('admin.assessments.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelompok
            </a>
        </div>
    </div>

    @if($groups->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada kelompok penilaian</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan kelompok penilaian pertama untuk memulai</p>
            <a href="{{ route('admin.assessments.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kelompok Pertama
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($groups as $group)
            <div class="card">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            @if($group->icon)
                                <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600">
                                    {!! $group->icon !!}
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-800 text-lg">{{ $group->title }}</h3>
                                <p class="text-xs text-gray-400">/{{ $group->slug }} &middot; Urutan: {{ $group->order }}</p>
                            </div>
                        </div>
                        @if($group->description)
                            <p class="text-sm text-gray-500 ml-0 @if($group->icon) ml-13 @endif">{{ $group->description }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-2">{{ $group->sub_groups_count }} sub-kelompok</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.assessments.sub-groups.create', $group->id) }}" class="text-sm font-medium text-primary-600 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors">
                            + Sub
                        </a>
                        @foreach($group->subGroups as $sub)
                            <a href="{{ route('admin.assessments.options.index', [$group->id, $sub->id]) }}" class="text-sm font-medium text-gray-500 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition-colors" title="Opsi: {{ $sub->title }}">
                                Opsi
                            </a>
                        @endforeach
                        <a href="{{ route('admin.assessments.edit', $group->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.assessments.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Hapus kelompok ini beserta semua sub-kelompok dan opsi?')">
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
                @if($group->subGroups->isNotEmpty())
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-600 mb-3">Sub-Kelompok:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($group->subGroups as $sub)
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $sub->title }}</p>
                                <p class="text-xs text-gray-400">{{ $sub->options->count() }} opsi &middot; Urutan: {{ $sub->order }}</p>
                            </div>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('admin.assessments.sub-groups.edit', [$group->id, $sub->id]) }}" class="p-1.5 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('admin.assessments.sub-groups.destroy', [$group->id, $sub->id]) }}" method="POST" onsubmit="return confirm('Hapus sub-kelompok ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
