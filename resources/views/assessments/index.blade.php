@extends('layouts.app')

@section('title', 'Assessment Kaki Diabetes')
@section('page-title', 'Assessment Kaki Diabetes')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    @include('admin.partials.data-entry-banner', ['backUrl' => route('admin.monitoring.assessments')])

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 text-red-700 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="card text-center">
        <div class="w-20 h-20 mx-auto rounded-full bg-pink-100 flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zm-7.518-.267A8.25 8.25 0 1120.25 10.5M8.288 14.212A5.25 5.25 0 1117.25 10.5" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-3">Assessment Kaki Diabetes</h2>
        <p class="text-gray-500 max-w-lg mx-auto mb-2">
            Penilaian mandiri kondisi kaki untuk mendeteksi risiko komplikasi diabetes pada kaki Anda.
        </p>
        <p class="text-sm text-gray-400 mb-6">
            Anda akan menilai kondisi kulit dan kuku kaki kiri dan kanan. Hasil akan dicocokkan dengan aturan klinis untuk memberikan rekomendasi.
        </p>
        <a href="{{ route('assessment.start') }}" class="btn-primary inline-flex items-center gap-2 text-lg px-8 py-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Mulai Penilaian
        </a>
    </div>

    @if($groups->isNotEmpty())
    <div class="card">
        <h3 class="font-semibold text-gray-800 text-lg mb-4">Kelompok Penilaian</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($groups as $group)
            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl">
                @if($group->icon)
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                        {!! $group->icon !!}
                    </div>
                @else
                    <div class="w-12 h-12 rounded-xl bg-primary-50 flex items-center justify-center text-primary-600 flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                @endif
                <div>
                    <h4 class="font-semibold text-gray-800">{{ $group->title }}</h4>
                    @if($group->description)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $group->description }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="flex items-center justify-center">
        <a href="{{ route('assessment.history') }}" class="text-sm text-gray-400 hover:text-primary-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Lihat Riwayat Penilaian
        </a>
    </div>

</div>
@endsection
