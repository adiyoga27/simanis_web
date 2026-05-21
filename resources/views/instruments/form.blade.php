@extends('layouts.app')

@section('title', 'Instrument Keyakinan')
@section('page-title', 'Instrument Keyakinan')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">

    <div class="text-center">
        <h2 class="text-xl font-bold text-gray-800">Instrument Keyakinan</h2>
        <p class="text-sm text-gray-400 mt-1">Jawab seluruh pertanyaan berikut dengan jujur</p>
    </div>

    <form action="{{ route('instruments.store') }}" method="POST">
        @csrf

        @foreach($groups as $group)
        <div class="card mb-6">
            <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $group->title }}</h3>
            @if($group->description)
                <p class="text-sm text-gray-400 mb-4">{{ $group->description }}</p>
            @endif

            <div class="space-y-6">
                @foreach($group->questions as $q)
                <div class="pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                    <p class="text-sm font-medium text-gray-700 mb-3">{{ $loop->parent->index + 1 }}.{{ $loop->index + 1 }} {{ $q->question }}</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach([1 => 'Tidak Setuju', 2 => 'Kurang Setuju', 3 => 'Setuju'] as $val => $label)
                        <label class="flex items-center justify-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-primary-300 hover:bg-primary-50/50 transition-colors has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50 has-[:checked]:text-primary-700">
                            <input type="radio" name="answers[{{ $q->id }}]" value="{{ $val }}" class="sr-only" required>
                            <span class="text-xs font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                    @error("answers.{$q->id}")
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex items-center gap-3">
            <a href="{{ route('instruments.history') }}" class="btn-white flex-1 text-center">Lihat Riwayat</a>
            <button type="submit" class="btn-primary flex-1">Submit Jawaban</button>
        </div>
    </form>

</div>
@endsection
