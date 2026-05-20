@extends('layouts.app')

@section('title', isset($rule) && $rule->id ? 'Edit Aturan' : 'Tambah Aturan')
@section('page-title', isset($rule) && $rule->id ? 'Edit Aturan' : 'Tambah Aturan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        <form id="ruleForm" action="{{ isset($rule) && $rule->id ? route('admin.assessments.rules.update', $rule->id) : route('admin.assessments.rules.store') }}" method="POST">
            @csrf
            @if(isset($rule) && $rule->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $rule->title ?? '') }}"
                        placeholder="Contoh: Indikasi Normal"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="2"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Penjelasan singkat aturan...">{{ old('description', $rule->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="input-label">Kondisi (Group &ge; Minimum Skor) <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400 mb-3">Tambahkan satu atau lebih kondisi. Semua kondisi harus terpenuhi (AND).</p>

                    <div id="conditions-container" class="space-y-2 mb-3"></div>

                    <button type="button" class="text-sm font-medium text-primary-600 hover:text-primary-700 inline-flex items-center gap-1" onclick="addCondition()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Kondisi
                    </button>

                    <input type="hidden" name="conditions" id="conditions-json">
                    @error('conditions')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="result_text" class="input-label">Teks Hasil <span class="text-red-500">*</span></label>
                    <textarea name="result_text" id="result_text" rows="3"
                        class="input-field @error('result_text') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Teks yang ditampilkan saat aturan ini cocok..."
                        required>{{ old('result_text', $rule->result_text ?? '') }}</textarea>
                    @error('result_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="severity" class="input-label">Tingkat Keparahan <span class="text-red-500">*</span></label>
                    <select name="severity" id="severity"
                        class="input-field @error('severity') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        required>
                        <option value="">Pilih Tingkat</option>
                        <option value="normal" {{ old('severity', $rule->severity ?? '') == 'normal' ? 'selected' : '' }}>Normal (Hijau)</option>
                        <option value="ringan" {{ old('severity', $rule->severity ?? '') == 'ringan' ? 'selected' : '' }}>Ringan (Kuning)</option>
                        <option value="sedang" {{ old('severity', $rule->severity ?? '') == 'sedang' ? 'selected' : '' }}>Sedang (Orange)</option>
                        <option value="tinggi" {{ old('severity', $rule->severity ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi (Merah)</option>
                    </select>
                    @error('severity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $rule->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($rule) && $rule->id ? 'Simpan Perubahan' : 'Simpan Aturan' }}
                </button>
                <a href="{{ route('admin.assessments.rules.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let conditionIndex = 0;

    function buildConditionRow(group, score) {
        let idx = conditionIndex++;
        let options = '';
        @foreach($groups as $g)
            options += '<option value="{{ $g->id }}"' + (group == '{{ $g->id }}' ? ' selected' : '') + '>{{ $g->title }}</option>';
        @endforeach

        return '<div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3" data-condition="' + idx + '">' +
            '<select name="cond_group_' + idx + '" class="input-field flex-1 !py-2" required>' +
                '<option value="">Pilih Kelompok</option>' + options +
            '</select>' +
            '<span class="text-sm text-gray-400 font-medium">&ge;</span>' +
            '<input type="number" name="cond_score_' + idx + '" class="input-field w-24 !py-2" placeholder="Skor" min="0" required value="' + (score || 0) + '">' +
            '<button type="button" class="p-2 rounded-lg text-red-400 hover:bg-red-50 transition-colors" onclick="this.parentElement.remove(); updateConditionsJson()" title="Hapus">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
            '</button>' +
        '</div>';
    }

    function addCondition(group, score) {
        document.getElementById('conditions-container').insertAdjacentHTML('beforeend', buildConditionRow(group || '', score || 0));
        updateConditionsJson();
    }

    function updateConditionsJson() {
        let container = document.getElementById('conditions-container');
        let rows = container.querySelectorAll('[data-condition]');
        let obj = {};
        rows.forEach(function(row) {
            let select = row.querySelector('select');
            let input = row.querySelector('input[type="number"]');
            if (select && input && select.value) {
                obj[select.value] = parseInt(input.value) || 0;
            }
        });
        document.getElementById('conditions-json').value = JSON.stringify(obj);
    }

    document.addEventListener('DOMContentLoaded', function() {
        @php
            $conds = old('_cond', isset($rule) && $rule->conditions ? $rule->conditions : []);
            if (is_array($conds) && !empty($conds)) {
                foreach ($conds as $gId => $score) {
                    echo "addCondition('{$gId}', {$score});";
                }
            }
        @endphp
        if (document.getElementById('conditions-container').children.length === 0) {
            addCondition();
        }
    });

    document.getElementById('ruleForm').addEventListener('submit', function() {
        updateConditionsJson();
    });

    document.addEventListener('change', function(e) {
        if (e.target.closest('#conditions-container')) {
            updateConditionsJson();
        }
    });
</script>
@endpush
