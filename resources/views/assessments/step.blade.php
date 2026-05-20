@extends('layouts.app')

@section('title', $group->title)
@section('page-title', 'Assessment Kaki Diabetes')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Progress Bar --}}
    <div class="card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm font-medium text-gray-500">Langkah {{ $currentIndex + 1 }} dari {{ $totalGroups }}</span>
            <span class="text-sm font-semibold text-primary-600">{{ $group->title }}</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-primary-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ (($currentIndex + 1) / $totalGroups) * 100 }}%"></div>
        </div>
        <div class="flex justify-between mt-2">
            @foreach($groups as $idx => $g)
                <span class="text-xs {{ $idx < $currentIndex ? 'text-primary-600 font-medium' : ($idx == $currentIndex ? 'text-primary-600 font-bold' : 'text-gray-300') }}">
                    {{ $g->title }}
                </span>
            @endforeach
        </div>
    </div>

    @if($group->description)
        <p class="text-sm text-gray-500">{{ $group->description }}</p>
    @endif

    <form action="{{ route('assessment.save', $group->slug) }}" method="POST">
        @csrf

        @foreach($group->subGroups as $subGroup)
        <div class="card mb-4">
            <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $subGroup->title }}</h3>
            @if($subGroup->description)
                <p class="text-sm text-gray-400 mb-4">{{ $subGroup->description }}</p>
            @endif

            <div class="space-y-3">
                @foreach($subGroup->options as $option)
                <label class="flex items-start gap-4 p-4 rounded-xl border-2 border-gray-100 hover:border-primary-300 cursor-pointer transition-all duration-200 has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50/50">
                    <input type="radio"
                        name="options[{{ $subGroup->id }}]"
                        value="{{ $option->id }}"
                        class="mt-1 w-5 h-5 text-primary-600 focus:ring-primary-500 border-gray-300"
                        {{ isset($selections[$group->id][$subGroup->id]) && $selections[$group->id][$subGroup->id]['option_id'] == $option->id ? 'checked' : '' }}
                        required>
                    <div class="flex-1 min-w-0">
                        @if($option->image)
                            <img src="{{ asset('storage/' . $option->image) }}" alt="{{ $option->text }}" class="w-full max-w-xs rounded-xl object-cover mb-2 border border-gray-200">
                        @endif
                        <p class="text-sm text-gray-700 font-medium">{{ $option->text }}</p>
                        <span class="text-xs text-gray-400">Skor: {{ $option->score }}</span>
                    </div>
                </label>
                @endforeach
            </div>

            @error("options.{$subGroup->id}")
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>
        @endforeach

        <div class="flex items-center gap-3">
            @if($prevGroup)
                <a href="{{ route('assessment.step', $prevGroup->slug) }}" class="btn-white inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            @endif
            <button type="submit" class="btn-primary flex-1 inline-flex items-center justify-center gap-2">
                {{ $isLast ? 'Lihat Hasil' : 'Selanjutnya' }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </form>

</div>
@endsection
