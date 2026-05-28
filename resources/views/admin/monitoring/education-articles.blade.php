@extends('layouts.app')

@section('title', $category->title)
@section('page-title', 'Pilar Tata Laksana')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm">
        <a href="{{ route('admin.monitoring.education') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Pilar Tata Laksana</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="font-semibold text-gray-700">{{ $category->title }}</span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-lg" style="background-color: {{ $category->color ?? '#06B6D4' }}">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $category->title }}</h2>
                <p class="text-sm text-gray-400">{{ $educations->count() }} artikel</p>
            </div>
        </div>
    </div>

    {{-- Sidebar Kategori + Daftar Artikel --}}
    <div class="flex flex-col lg:flex-row gap-6">
        {{-- Sidebar --}}
        <div class="lg:w-56 flex-shrink-0">
            <div class="card !p-4 sticky top-20">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Kategori</p>
                <div class="space-y-1">
                    @foreach($categories as $cat)
                    <a href="{{ route('admin.monitoring.education.articles', $cat->slug) }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm transition-all duration-200 {{ $cat->id === $category->id ? 'bg-cyan-50 text-cyan-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $cat->color ?? '#06B6D4' }}"></span>
                            {{ $cat->title }}
                        </span>
                        <span class="text-xs {{ $cat->id === $category->id ? 'text-cyan-500' : 'text-gray-400' }}">{{ $cat->educations_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Articles Grid --}}
        <div class="flex-1 min-w-0">
            @if($educations->isEmpty())
                <div class="card text-center py-20 text-gray-400 rounded-3xl">
                    <p class="font-semibold text-gray-500">Belum ada artikel di kategori ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($educations as $edu)
                    <a href="{{ route('admin.monitoring.education.detail', [$category->slug, $edu->slug]) }}" class="group card !p-0 overflow-hidden rounded-3xl border-0 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        @if($edu->image)
                        <div class="relative h-44 overflow-hidden">
                            <img src="{{ asset('storage/' . $edu->image) }}" alt="{{ $edu->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        @else
                        <div class="h-44 bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center group-hover:from-cyan-500 group-hover:to-blue-600 transition-all duration-500">
                            <svg class="w-14 h-14 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        @endif
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-cyan-600 transition-colors">{{ $edu->title }}</h4>
                            <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ \Carbon\Carbon::parse($edu->created_at)->format('d M Y') }}
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
