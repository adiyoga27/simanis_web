@extends('layouts.app')

@section('title', $group->title)
@section('page-title', 'Assessment Kaki Diabetes')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.assessments')])

    {{-- Progress --}}
    <div class="card !p-4 sm:!p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs sm:text-sm font-medium text-gray-400">Langkah {{ $currentIndex + 1 }} dari {{ $totalGroups }}</span>
            <span class="text-xs sm:text-sm font-bold text-primary-600 truncate ml-2">{{ $group->title }}</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ (($currentIndex + 1) / $totalGroups) * 100 }}%"></div>
        </div>
        {{-- Step dots for mobile --}}
        <div class="flex justify-center gap-1.5 mt-3 sm:hidden">
            @foreach($groups as $idx => $g)
                <span class="w-2 h-2 rounded-full {{ $idx < $currentIndex ? 'bg-primary-400' : ($idx == $currentIndex ? 'bg-primary-600 w-4' : 'bg-gray-300') }} transition-all duration-300"></span>
            @endforeach
        </div>
        {{-- Step labels for desktop --}}
        <div class="hidden sm:flex justify-between mt-2">
            @foreach($groups as $idx => $g)
                <span class="text-xs {{ $idx < $currentIndex ? 'text-primary-500 font-medium' : ($idx == $currentIndex ? 'text-primary-600 font-bold' : 'text-gray-300') }} max-w-[80px] text-center truncate">{{ $g->title }}</span>
            @endforeach
        </div>
    </div>

    @if($group->description)
        <div class="flex items-start gap-3 px-1">
            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-gray-500">{{ $group->description }}</p>
        </div>
    @endif

    @if($currentIndex > 0 && !empty($group->image))
        <div class="card !p-2 overflow-hidden rounded-3xl border-0">
            <img src="{{ asset('storage/' . $group->image) }}" alt="Ilustrasi {{ $group->title }}" class="w-full h-48 sm:h-56 object-cover rounded-2xl">
        </div>
    @endif

    <form action="{{ route('assessment.save', $group->slug) }}" method="POST">
        @csrf

        @foreach($group->subGroups as $subGroup)
        <div class="card !p-4 sm:!p-5 mb-4">
            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-1">{{ $subGroup->title }}</h3>
            @if($subGroup->description)
                <p class="text-sm text-gray-400 mb-4">{{ $subGroup->description }}</p>
            @endif

            <div class="space-y-2.5">
                @foreach($subGroup->options as $option)
                <label class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-2xl border-2 border-gray-100 hover:border-primary-300 hover:bg-primary-50/30 cursor-pointer transition-all duration-200 has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50/50 has-[:checked]:shadow-sm">
                    <input type="radio"
                        name="options[{{ $subGroup->id }}]"
                        value="{{ $option->id }}"
                        class="mt-0.5 w-5 h-5 text-primary-600 focus:ring-primary-400 border-gray-300 flex-shrink-0"
                        {{ isset($selections[$group->id][$subGroup->id]) && $selections[$group->id][$subGroup->id]['option_id'] == $option->id ? 'checked' : '' }}
                        required>
                    <div class="flex-1 min-w-0">
                        @if($option->image)
                            <img src="{{ asset('storage/' . $option->image) }}" alt="{{ $option->text }}" class="w-full max-w-xs rounded-xl object-cover mb-2 border border-gray-100">
                        @endif
                        <p class="text-sm sm:text-base text-gray-700 font-medium">{{ $option->text }}</p>
                        <span class="inline-flex items-center gap-1 mt-1.5 text-xs text-gray-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Skor {{ $option->score }}
                        </span>
                    </div>
                </label>
                @endforeach
            </div>

            @error("options.{$subGroup->id}")
                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>
        @endforeach

        {{-- Navigation --}}
        <div class="flex items-center gap-3 pt-2 pb-4 sm:pb-0">
            @if($prevGroup)
                <a href="{{ route('assessment.step', $prevGroup->slug) }}" class="btn-white !py-3 !rounded-2xl inline-flex items-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            @endif
            <button type="submit" class="btn-primary flex-1 !py-3 !rounded-2xl !text-base inline-flex items-center justify-center gap-2 shadow-lg shadow-primary-200 hover:shadow-xl hover:shadow-primary-300 transition-all duration-300">
                <span>{{ $isLast ? 'Lihat Hasil' : 'Selanjutnya' }}</span>
                @if(!$isLast)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </button>
        </div>
    </form>

</div>
@endsection
