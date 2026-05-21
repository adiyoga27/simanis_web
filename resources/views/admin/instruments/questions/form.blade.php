@extends('layouts.app')

@section('title', isset($question->id) ? 'Edit Pertanyaan' : 'Tambah Pertanyaan')
@section('page-title', isset($question->id) ? 'Edit Pertanyaan' : 'Tambah Pertanyaan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card">
        <p class="text-sm text-gray-400 mb-4">Grup: <strong>{{ $group->title }}</strong></p>
        <form action="{{ isset($question->id) ? route('admin.instruments.questions.update', $question->id) : route('admin.instruments.questions.store', $group->id) }}" method="POST">
            @csrf
            @if(isset($question->id)) @method('PUT') @endif

            <div class="space-y-4">
                <div>
                    <label class="input-label">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea name="question" rows="3" class="input-field @error('question') border-red-300 @enderror" required>{{ old('question', $question->question ?? '') }}</textarea>
                    @error('question') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="input-label">Urutan</label>
                    <input type="number" name="order" class="input-field" value="{{ old('order', $question->order ?? 0) }}" min="0">
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">Simpan</button>
                <a href="{{ route('admin.instruments.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
