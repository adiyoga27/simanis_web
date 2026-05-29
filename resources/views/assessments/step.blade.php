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
        {{-- Step indicators for desktop --}}
        <div class="hidden sm:flex items-start justify-between mt-3 gap-1">
             @foreach($groups as $idx => $g)
                @php
                    $isCompleted = $idx < $currentIndex;
                    $isCurrent = $idx == $currentIndex;
                    $isLastStep = $idx == count($groups) - 1;
                @endphp
                
                <div class="flex-1 flex flex-col items-center min-w-0">
                    <div class="flex items-center w-full">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold flex-shrink-0 transition-all duration-300
                            {{ $isCompleted ? 'bg-primary-500 text-white shadow-sm shadow-primary-200' : '' }}
                            {{ $isCurrent ? 'bg-primary-600 text-white shadow-md shadow-primary-300 ring-2 ring-primary-200' : '' }}
                            {{ !$isCompleted && !$isCurrent ? 'bg-gray-200 text-gray-400' : '' }}">
                            @if($isCompleted)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $idx + 1 }}
                            @endif
                        </span>
                        @if(!$isLastStep)
                            <div class="flex-1 h-0.5 mx-0.5 rounded {{ $isCompleted ? 'bg-primary-400' : 'bg-gray-200' }} transition-colors duration-300"></div>
                        @endif
                    </div>
                    <span class="text-[10px] mt-1.5 text-center leading-tight {{ $isCompleted ? 'text-primary-500 font-medium' : ($isCurrent ? 'text-primary-600 font-semibold' : 'text-gray-400') }} line-clamp-2">
                        {{ $g->title }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    @if($group->description)
        <div class="flex items-start gap-3 px-1">
            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-gray-500">{!! nl2br(e($group->description)) !!}</p>
        </div>
    @endif

    @if($currentIndex > 0 && !empty($group->image))
        <div class="card !p-2 overflow-hidden rounded-3xl border-0">
            <img src="{{ asset('storage/' . $group->image) }}" alt="Ilustrasi {{ $group->title }}" class="w-full h-48 sm:h-56 object-cover rounded-2xl cursor-pointer hover:opacity-90 transition-opacity" onclick="openZoom('{{ asset('storage/' . $group->image) }}')">
        </div>
    @endif

    <form action="{{ route('assessment.save', $group->slug) }}" method="POST">
        @csrf

        @foreach($group->subGroups as $subGroup)
        <div class="card !p-4 sm:!p-5 mb-4">
            <h3 class="font-bold text-gray-800 text-base sm:text-lg mb-1">{{ $subGroup->title }}</h3>
            @if($subGroup->description)
                <p class="text-sm text-gray-400 mb-4">{!! nl2br(e($subGroup->description)) !!}</p>
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
                            <div class="relative inline-block group cursor-pointer mb-2" onclick="event.stopPropagation();openZoom('{{ asset('storage/' . $option->image) }}')">
                                <img src="{{ asset('storage/' . $option->image) }}" alt="{{ $option->text }}" class="w-full max-w-xs rounded-xl object-cover border border-gray-100 group-hover:brightness-90 transition-all">
                                <div class="absolute inset-0 flex items-center justify-center rounded-xl bg-black/0 group-hover:bg-black/20 transition-all">
                                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                            </div>
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
                <span>{{ $isLast ? 'Lihat Hasil' : 'Lanjutkan' }}</span>
                @if(!$isLast)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                @else
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </button>
        </div>
    </form>

    {{-- Image Zoom Modal --}}
    <div id="zoomModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4" onclick="closeZoom()">
        <div class="relative max-w-4xl max-h-[90vh] flex items-center justify-center" onclick="event.stopPropagation()">
            <button onclick="closeZoom()" class="absolute -top-10 right-0 p-2 text-white/70 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img id="zoomImage" src="" alt="" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl">
        </div>
    </div>

    <script>
        function openZoom(src) {
            document.getElementById('zoomImage').src = src;
            document.getElementById('zoomModal').classList.remove('hidden');
            document.getElementById('zoomModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeZoom() {
            document.getElementById('zoomModal').classList.add('hidden');
            document.getElementById('zoomModal').classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeZoom();
        });
    </script>

</div>
@endsection
