@extends('layouts.app')

@section('title', 'Aturan Penilaian')
@section('page-title', 'Aturan Penilaian Kaki Diabetes')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 text-green-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Daftar Aturan Penilaian</h2>
            <p class="text-sm text-gray-400 mt-0.5">Kelola aturan pencocokan skor dan hasil penilaian</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.assessments.index') }}" class="btn-white inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Kelompok
            </a>
            <a href="{{ route('admin.assessments.rules.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Aturan
            </a>
        </div>
    </div>

    @if($rules->isEmpty())
        <div class="card text-center py-16">
            <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum ada aturan penilaian</h3>
            <p class="text-sm text-gray-400 mb-6">Tambahkan aturan untuk mencocokkan skor dengan hasil penilaian</p>
            <a href="{{ route('admin.assessments.rules.create') }}" class="btn-primary inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Aturan Pertama
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($rules as $rule)
            <div class="card">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="font-semibold text-gray-800 text-lg">{{ $rule->title }}</h3>
                            @php
                                $severityColors = [
                                    'normal' => 'badge-green',
                                    'ringan' => 'badge-yellow',
                                    'sedang' => 'bg-orange-100 text-orange-700 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold',
                                    'tinggi' => 'badge-red',
                                ];
                            @endphp
                            <span class="{{ $severityColors[$rule->severity] ?? 'badge' }}">{{ ucfirst($rule->severity) }}</span>
                        </div>
                        @if($rule->description)
                            <p class="text-sm text-gray-500 mb-2">{{ $rule->description }}</p>
                        @endif
                        <div class="mb-2">
                            <span class="text-xs font-medium text-gray-500">Kondisi:</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($rule->conditions as $groupId => $minScore)
                                    @php $groupModel = \App\Models\AssessmentGroup::find($groupId); @endphp
                                    <span class="badge bg-gray-100 text-gray-600 text-xs">
                                        {{ $groupModel?->title ?? 'Group #'.$groupId }} &ge; {{ $minScore }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 italic mt-2">"{{ Str::limit($rule->result_text, 120) }}"</p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <a href="{{ route('admin.assessments.rules.edit', $rule->id) }}" class="p-2 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.assessments.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus aturan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
