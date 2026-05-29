@extends('layouts.app')

@section('title', isset($conclusion) && $conclusion->id ? 'Edit Kesimpulan' : 'Tambah Kesimpulan')
@section('page-title', isset($conclusion) && $conclusion->id ? 'Edit Kesimpulan' : 'Tambah Kesimpulan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card">
        <form action="{{ isset($conclusion) && $conclusion->id ? route('admin.assessments.conclusions.update', $conclusion->id) : route('admin.assessments.conclusions.store') }}" method="POST">
            @csrf
            @if(isset($conclusion) && $conclusion->id)
                @method('PUT')
            @endif

            <div class="space-y-5">
                <div>
                    <label for="title" class="input-label">Judul <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title"
                        class="input-field @error('title') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('title', $conclusion->title ?? '') }}"
                        placeholder="Contoh: Risiko Tinggi - Perlu Rujukan"
                        required autofocus>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="input-label">Deskripsi</label>
                    <textarea name="description" id="description" rows="2"
                        class="input-field @error('description') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Penjelasan singkat...">{{ old('description', $conclusion->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category Conditions --}}
                <div>
                    <label class="input-label">Kondisi Kategori <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400 mb-3">Tentukan kategori dan jumlah minimal aturan yang harus cocok. Semua kondisi harus terpenuhi (AND).</p>

                    <div id="cond-container" class="space-y-2 mb-3"></div>

                    <button type="button" class="text-sm font-medium text-primary-600 hover:text-primary-700 inline-flex items-center gap-1" onclick="addCondRow()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Kondisi Kategori
                    </button>
                    @error('cond_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="result_text" class="input-label">Teks Kesimpulan & Penanganan <span class="text-red-500">*</span></label>
                    <textarea name="result_text" id="result_text" rows="3"
                        class="input-field @error('result_text') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        placeholder="Teks kesimpulan dan rekomendasi penanganan yang ditampilkan di hasil."
                        required>{{ old('result_text', $conclusion->result_text ?? '') }}</textarea>
                    @error('result_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reference_link" class="input-label">Link Rekomendasi / Penanganan</label>
                    <input type="url" name="reference_link" id="reference_link"
                        class="input-field @error('reference_link') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('reference_link', $conclusion->reference_link ?? '') }}"
                        placeholder="https://diamondcare.id/rekomendasi/...">
                    <p class="text-xs text-gray-400 mt-1">Link akan muncul pada hasil assessment sebagai rekomendasi penanganan.</p>
                    @error('reference_link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="severity" class="input-label">Tingkat Keparahan <span class="text-red-500">*</span></label>
                        <select name="severity" id="severity"
                            class="input-field @error('severity') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            required>
                            <option value="">Pilih Tingkat</option>
                            <option value="normal" {{ old('severity', $conclusion->severity ?? '') == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="ringan" {{ old('severity', $conclusion->severity ?? '') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                            <option value="sedang" {{ old('severity', $conclusion->severity ?? '') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('severity', $conclusion->severity ?? '') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('severity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="priority" class="input-label">Prioritas <span class="text-red-500">*</span></label>
                        <input type="number" name="priority" id="priority"
                            class="input-field @error('priority') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                            value="{{ old('priority', $conclusion->priority ?? 0) }}"
                            min="0"
                            required>
                        <p class="text-xs text-gray-400 mt-1">0 = prioritas tertinggi.</p>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="color" class="input-label">Warna Custom (opsional)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="color-pick"
                            value="{{ old('color', $conclusion->color ?? '#EF4444') }}"
                            class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-0"
                            oninput="document.getElementsByName('color')[0].value = this.value">
                        <input type="text" name="color"
                            class="input-field flex-1"
                            value="{{ old('color', $conclusion->color ?? '#EF4444') }}"
                            placeholder="#EF4444"
                            maxlength="30"
                            oninput="document.getElementById('color-pick').value = this.value">
                    </div>
                    @error('color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order" class="input-label">Urutan Tampil</label>
                    <input type="number" name="order" id="order"
                        class="input-field @error('order') border-red-300 focus:border-red-400 focus:ring-red-400/20 @enderror"
                        value="{{ old('order', $conclusion->order ?? 0) }}"
                        min="0">
                    @error('order')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                <button type="submit" class="btn-primary flex-1">
                    {{ isset($conclusion) && $conclusion->id ? 'Simpan Perubahan' : 'Simpan Kesimpulan' }}
                </button>
                <a href="{{ route('admin.assessments.conclusions.index') }}" class="btn-white flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let condIndex = 0;

    function buildCondRow(catId, minMatched, severity, logic, isFirst) {
        let idx = condIndex++;
        let catOptions = '';
        @foreach($categories as $cat)
            catOptions += '<option value="{{ $cat->id }}"' + (catId == '{{ $cat->id }}' ? ' selected' : '') + '>{{ $cat->title }}</option>';
        @endforeach

        let logicHtml = isFirst ? '<input type="hidden" name="cond_logic[]" value="and"><span class="w-16"></span>' :
            '<select name="cond_logic[]" class="input-field w-16 !py-2 text-xs text-center font-semibold">' +
                '<option value="and"' + (logic == 'and' ? ' selected' : '') + '>AND</option>' +
                '<option value="or"' + (logic == 'or' ? ' selected' : '') + '>OR</option>' +
            '</select>';

        return '<div class="flex items-center gap-2 bg-gray-50 rounded-xl p-3" data-cond="' + idx + '">' +
            logicHtml +
            '<select name="cond_category_id[]" class="input-field flex-1 !py-2">' +
                '<option value="">Pilih Kategori</option>' + catOptions +
            '</select>' +
            '<span class="text-xs text-gray-400">&ge;</span>' +
            '<input type="number" name="cond_min_matched[]" class="input-field w-16 !py-2 text-center" placeholder="1" min="1" value="' + (minMatched || 1) + '">' +
            '<select name="cond_severity[]" class="input-field w-28 !py-2 text-xs">' +
                '<option value="">Semua</option>' +
                '<option value="normal"' + (severity == 'normal' ? ' selected' : '') + '>Normal</option>' +
                '<option value="ringan"' + (severity == 'ringan' ? ' selected' : '') + '>Ringan</option>' +
                '<option value="sedang"' + (severity == 'sedang' ? ' selected' : '') + '>Sedang</option>' +
                '<option value="tinggi"' + (severity == 'tinggi' ? ' selected' : '') + '>Tinggi</option>' +
            '</select>' +
            '<button type="button" class="p-1.5 rounded-lg text-red-400 hover:bg-red-50 transition-colors" onclick="this.parentElement.remove()" title="Hapus">' +
                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>' +
            '</button>' +
        '</div>';
    }

    function addCondRow(catId, minMatched, severity, logic) {
        let isFirst = document.getElementById('cond-container').children.length === 0;
        document.getElementById('cond-container').insertAdjacentHTML('beforeend', buildCondRow(catId || '', minMatched || 1, severity || '', logic || 'and', isFirst));
    }

    document.addEventListener('DOMContentLoaded', function() {
        @php
            if (isset($conclusion) && $conclusion->conditions) {
                foreach ($conclusion->conditions as $cond) {
                    echo "addCondRow('{$cond->rule_category_id}', {$cond->min_matched_rules}, '{$cond->target_severity}', '{$cond->logic}');";
                }
            }
        @endphp
        if (document.getElementById('cond-container').children.length === 0) {
            addCondRow();
        }
    });
</script>
@endpush
