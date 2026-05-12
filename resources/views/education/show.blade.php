@extends('layouts.app')

@section('title', $education->title ?? 'Artikel Edukasi')

@section('page-title', $education->title ?? 'Artikel Edukasi')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm flex-wrap">
        <a href="{{ route('education') }}" class="text-gray-500 hover:text-primary-600 transition-colors">Pilar Tata Laksana</a>
        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        @if(!empty($category))
        <a href="{{ route('education.detail', $category->slug ?? 'edukasi') }}" class="text-gray-500 hover:text-primary-600 transition-colors">{{ $category->title ?? 'Kategori' }}</a>
        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        @endif
        <span class="font-semibold text-primary-600 truncate">{{ $education->title ?? '' }}</span>
    </nav>

    {{-- Back Button --}}
    @if(!empty($category))
    <a href="{{ route('education.detail', $category->slug ?? 'edukasi') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke {{ $category->title ?? 'kategori' }}
    </a>
    @endif

    {{-- Article Header --}}
    <article class="card overflow-hidden">
        @if(!empty($education->image))
        <div class="-mx-6 -mt-6 mb-6">
            <img src="{{ asset('storage/' . $education->image) }}" alt="{{ $education->title }}" class="w-full max-h-96 object-cover">
        </div>
        @else
        <div class="-mx-6 -mt-6 mb-6 h-56 bg-gradient-to-br from-primary-500 via-pink-500 to-primary-600 flex items-center justify-center">
            <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        @endif

        <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-900 leading-tight">{{ $education->title }}</h1>

        @if(!empty($education->created_at))
        <div class="flex items-center gap-4 mt-4 text-sm text-gray-400">
            <span class="inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ \Carbon\Carbon::parse($education->created_at)->translatedFormat('d F Y') }}
            </span>
        </div>
        @endif

        {{-- Article Content --}}
        <div class="mt-8 prose max-w-none prose-headings:text-gray-900 prose-headings:font-bold prose-p:text-gray-700 prose-p:leading-relaxed prose-a:text-primary-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-img:shadow-lg prose-strong:text-gray-900 prose-ul:text-gray-700 prose-ol:text-gray-700 prose-li:leading-relaxed prose-blockquote:border-l-primary-500 prose-blockquote:bg-primary-50 prose-blockquote:py-1 prose-blockquote:px-4 prose-blockquote:rounded-r-lg prose-blockquote:text-gray-700">
            {!! $education->content ?? '' !!}
        </div>
    </article>

    {{-- Bottom Navigation --}}
    <div class="flex items-center justify-between">
        @if(!empty($category))
        <a href="{{ route('education.detail', $category->slug ?? 'edukasi') }}" class="btn-white inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Semua Artikel
        </a>
        @endif
        <a href="{{ route('education') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary-600 transition-colors ml-auto">
            Pilar Tata Laksana
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

</div>
@endsection
