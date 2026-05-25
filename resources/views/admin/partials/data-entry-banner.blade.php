@if(session()->has('admin_data_entry_user_id'))
@php
    $entryUserName = session('admin_data_entry_user_name', 'Unknown');
    $backUrl = $backUrl ?? route('admin.dashboard');
@endphp
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 flex items-center justify-between gap-3">
    <div class="flex items-center gap-2 text-yellow-700 text-sm">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Anda sedang menginput data untuk: <strong>{{ $entryUserName }}</strong></span>
    </div>
    <a href="{{ route('admin.data-entry.clear', ['back' => $backUrl]) }}" class="text-xs font-medium text-yellow-700 hover:text-yellow-800 bg-yellow-100 hover:bg-yellow-200 px-3 py-1.5 rounded-lg transition-colors">
        Kembali ke Monitoring
    </a>
</div>
@endif
