@extends('layouts.app')

@section('title', 'Survey Screening Kaki Diabetik')
@section('page-title', 'Survey Screening Kaki Diabetik')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Info Card -->
    <div class="card">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-400 to-primary-400 flex items-center justify-center shadow-lg shadow-pink-400/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-gray-600 text-sm leading-relaxed">Jawablah pertanyaan berikut dengan jujur sesuai kondisi kaki Anda saat ini. Hasil screening ini bersifat informatif dan bukan pengganti diagnosis medis.</p>
        </div>
    </div>

    <!-- Survey Form -->
    <form id="screeningForm" action="{{ route('foot-screening.result') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="score" id="scoreInput" value="0">

        <!-- Question 1 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/20">1</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah Anda merasakan sensasi terbakar atau kesemutan pada kaki?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q1" value="1" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q1" value="0" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 2 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/20">2</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah Anda mengalami penurunan sensasi sentuhan pada kaki?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q2" value="1" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q2" value="0" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 3 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/20">3</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah Anda sering merasakan nyeri pada kaki?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q3" value="1" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q3" value="0" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 4 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/20">4</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah kaki Anda sering terasa dingin?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q4" value="1" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q4" value="0" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 5 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-primary-500/20">5</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah denyut nadi di kaki Anda terasa lemah?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q5" value="1" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q5" value="0" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 6 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-pink-400/20">6</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah kulit kaki Anda kering atau pecah-pecah?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q6" value="1" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q6" value="0" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 7 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-pink-400/20">7</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah terdapat kapalan (callus) pada kaki Anda?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q7" value="1" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q7" value="0" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Question 8 -->
        <div class="card">
            <div class="flex items-start gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-lg shadow-pink-400/20">8</div>
                <p class="text-gray-800 font-medium pt-0.5">Apakah terjadi perubahan bentuk pada kaki Anda?</p>
            </div>
            <div class="flex gap-4 pl-11">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q8" value="1" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Ya</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="q8" value="0" class="w-5 h-5 text-pink-500 border-gray-300 focus:ring-pink-500" required>
                    <span class="text-sm text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <!-- Hidden answer field for server processing -->
        <input type="hidden" name="answers" id="answersInput" value="">

        <!-- Submit -->
        <div class="card text-center">
            <button type="submit" class="btn-primary inline-flex items-center gap-2 text-lg px-10 py-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Lihat Hasil
            </button>
            <p class="text-xs text-gray-400 mt-3">Pastikan semua pertanyaan telah dijawab sebelum melihat hasil</p>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('screeningForm').addEventListener('submit', function(e) {
    const questions = ['q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8'];
    let score = 0;
    const answers = {};

    for (const q of questions) {
        const selected = this.querySelector('input[name="' + q + '"]:checked');
        if (!selected) {
            e.preventDefault();
            alert('Harap jawab semua pertanyaan sebelum melihat hasil.');
            return false;
        }
        const value = parseInt(selected.value);
        score += value;
        answers[q] = value;
    }

    document.getElementById('scoreInput').value = score;
    document.getElementById('answersInput').value = JSON.stringify(answers);
});
</script>
@endpush
