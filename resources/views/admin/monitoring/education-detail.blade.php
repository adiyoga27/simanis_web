@extends('layouts.app')

@section('title', $education->title)
@section('page-title', 'Pilar Tata Laksana')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm flex-wrap">
        <a href="{{ route('admin.monitoring.education') }}" class="text-gray-400 hover:text-gray-600 transition-colors">Pilar Tata Laksana</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('admin.monitoring.education.articles', $category->id) }}" class="text-gray-400 hover:text-gray-600 transition-colors">{{ $category->title }}</a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="font-semibold text-gray-700 line-clamp-1">{{ $education->title }}</span>
    </div>

    {{-- Article Header --}}
    <div class="card !p-0 overflow-hidden rounded-3xl border-0 shadow-lg">
        @if($education->image)
        <div class="h-56 sm:h-72 overflow-hidden">
            <img src="{{ asset('storage/' . $education->image) }}" alt="{{ $education->title }}" class="w-full h-full object-cover">
        </div>
        @else
        <div class="h-40 sm:h-48 bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
            <svg class="w-20 h-20 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        </div>
        @endif
        <div class="p-6 sm:p-8">
            <div class="flex items-center gap-2 mb-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $category->color ?? '#06B6D4' }}15; color: {{ $category->color ?? '#06B6D4' }}">{{ $category->title }}</span>
                <span class="text-xs text-gray-400 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ \Carbon\Carbon::parse($education->created_at)->format('d M Y') }}
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-gray-800 leading-tight mb-4">{{ $education->title }}</h1>
            <div class="prose prose-sm prose-gray max-w-none">
                {!! nl2br(e($education->content ?? '')) !!}
            </div>
        </div>
    </div>

    {{-- Back --}}
    <div class="text-center pb-6">
        <a href="{{ route('admin.monitoring.education.articles', $category->id) }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke {{ $category->title }}
        </a>
    </div>

</div>
@endsection
