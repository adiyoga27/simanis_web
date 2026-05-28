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
                    <label class="input-label">Indikator Skor <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 cursor-pointer hover:border-green-300 hover:bg-green-50/30 transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="score_type" value="favorable" class="w-5 h-5 text-green-600 focus:ring-green-400" {{ old('score_type', $question->score_type ?? 'favorable') === 'favorable' ? 'checked' : '' }} required>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Favorable <span class="text-green-500">(+)</span></p>
                                <p class="text-xs text-gray-400 mt-0.5">Jawaban setuju menambah skor</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-gray-100 cursor-pointer hover:border-red-300 hover:bg-red-50/30 transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="score_type" value="unfavorable" class="w-5 h-5 text-red-500 focus:ring-red-400" {{ old('score_type', $question->score_type ?? '') === 'unfavorable' ? 'checked' : '' }} required>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">Unfavorable <span class="text-red-500">(−)</span></p>
                                <p class="text-xs text-gray-400 mt-0.5">Jawaban setuju mengurangi skor</p>
                            </div>
                        </label>
                    </div>
                    @error('score_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
