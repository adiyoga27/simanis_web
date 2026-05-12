@extends('layouts.app')

@section('title', $category->title ?? 'Kategori Edukasi')

@section('page-title', $category->title ?? 'Kategori Edukasi')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <div class="flex items-center gap-3">
        <a href="{{ route('education') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-primary-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Pilar Tata Laksana
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-sm font-semibold text-primary-600">{{ $category->title ?? '' }}</span>
    </div>

    @if(isset($category) && $category)
    <div class="relative overflow-hidden rounded-2xl gradient-primary p-6 text-white shadow-xl shadow-primary-500/20">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="relative z-10">
            <h2 class="text-2xl font-bold">{{ $category->title }}</h2>
            @if(!empty($category->description))
            <p class="mt-2 text-white/80">{{ $category->description }}</p>
            @endif
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($educations ?? [] as $education)
            <a href="{{ route('education.show', [$category->slug ?? 'edukasi', $education->slug]) }}" class="card-clickable overflow-hidden flex flex-col group">
                <div class="h-48 relative overflow-hidden">
                    @if(!empty($education->image))
                        <img src="{{ asset('storage/' . $education->image) }}" alt="{{ $education->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-400 via-pink-400 to-primary-500 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="font-bold text-gray-800 group-hover:text-primary-600 transition-colors text-lg leading-snug">{{ $education->title }}</h3>
                    <p class="text-gray-500 text-sm mt-2 line-clamp-3 flex-1">
                        {{ Str::limit(strip_tags($education->content ?? ''), 100) }}
                    </p>
                    <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
                        Baca Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="card text-center py-16">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-600">Belum ada artikel</h3>
                    <p class="text-gray-400 mt-1">Konten edukasi sedang disiapkan. Silakan kembali lagi nanti.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
