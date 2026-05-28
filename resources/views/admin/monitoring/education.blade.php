@extends('layouts.app')

@section('title', 'Pilar Tata Laksana')
@section('page-title', 'Pilar Tata Laksana')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center shadow-lg shadow-cyan-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800">Pilar Tata Laksana</h2>
                <p class="text-sm text-gray-400">Pilih salah satu kategori edukasi</p>
            </div>
        </div>
    </div>

    @if($categories->isEmpty())
        <div class="card text-center py-20 text-gray-400 rounded-3xl">
            <div class="w-20 h-20 rounded-full bg-cyan-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="font-semibold text-gray-500 text-base">Belum ada kategori edukasi</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categories as $cat)
            <a href="{{ route('admin.monitoring.education.articles', $cat->slug) }}" class="card !p-0 overflow-hidden rounded-3xl border-0 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="h-36 bg-gradient-to-br flex items-center justify-center relative" style="background: linear-gradient(135deg, {{ $cat->color ?? '#06B6D4' }}15, {{ $cat->color ?? '#3B82F6' }}30)">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg" style="background-color: {{ $cat->color ?? '#06B6D4' }}">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="font-bold text-gray-800 group-hover:text-cyan-600 transition-colors">{{ $cat->title }}</h3>
                    </div>
                    <p class="text-xs text-gray-400">{{ $cat->educations_count }} artikel</p>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                        <span class="text-xs text-cyan-500 font-medium">Lihat Artikel</span>
                        <svg class="w-4 h-4 text-cyan-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
