@extends('layouts.app')

@section('title', 'Pilar Tata Laksana')

@section('page-title', 'Pilar Tata Laksana Diabetes')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto">

    <div class="text-center">
        <p class="text-gray-500 max-w-2xl mx-auto">Empat pilar utama dalam tata laksana diabetes melitus. Setiap pilar saling melengkapi untuk mencapai kualitas hidup optimal.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @php
            $pillars = [
                [
                    'title' => 'Edukasi',
                    'slug' => 'edukasi',
                    'description' => 'Informasi dan pengetahuan seputar diabetes melitus',
                    'color' => 'from-primary-500 to-red-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                    'route' => 'education.detail',
                    'routeParam' => 'edukasi',
                ],
                [
                    'title' => 'Terapi Nutrisi',
                    'slug' => 'nutrisi',
                    'description' => 'Pengaturan pola makan dan diet untuk diabetes',
                    'color' => 'from-pink-400 to-primary-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
                    'route' => 'tnt',
                    'routeParam' => null,
                ],
                [
                    'title' => 'Latihan Fisik',
                    'slug' => 'latihan-fisik',
                    'description' => 'Olahraga dan aktivitas fisik yang dianjurkan',
                    'color' => 'from-primary-600 to-pink-500',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                    'route' => 'education.detail',
                    'routeParam' => 'latihan-fisik',
                ],
                [
                    'title' => 'Perawatan Kaki',
                    'slug' => 'perawatan-kaki',
                    'description' => 'Cara merawat kaki untuk mencegah komplikasi',
                    'color' => 'from-pink-500 to-primary-500',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5"/>',
                    'route' => 'education.detail',
                    'routeParam' => 'perawatan-kaki',
                ],
            ];

            $categories = $categories ?? $pillars;
        @endphp

        @foreach($categories as $category)
            @php
                $isArray = is_array($category);
                $title = $isArray ? $category['title'] : ($category->title ?? '');
                $slug = $isArray ? $category['slug'] : ($category->slug ?? '');
                $description = $isArray ? $category['description'] : ($category->description ?? '');
                $color = $isArray ? $category['color'] : ($category->color ?? 'from-primary-500 to-pink-500');
                $icon = $isArray ? $category['icon'] : '';
                $routeName = $isArray ? $category['route'] : 'education.detail';
                $routeParam = $isArray ? $category['routeParam'] : $slug;
            @endphp
            <a href="{{ $routeParam ? route($routeName, $routeParam) : route($routeName) }}" class="card-clickable flex flex-col items-center text-center p-8 group">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $color }} flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($icon)
                            {!! $icon !!}
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        @endif
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 group-hover:text-primary-600 transition-colors">{{ $title }}</h3>
                <p class="text-gray-500 mt-2 text-sm leading-relaxed">{{ $description }}</p>
                <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
                    Jelajahi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            </a>
        @endforeach
    </div>

</div>
@endsection
