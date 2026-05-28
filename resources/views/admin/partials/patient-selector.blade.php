@if(in_array(Auth::user()->role, ['superadmin', 'kepala_puskesmas', 'kepala_desa']))
@php
$redirectTo = $redirectTo ?? '';
$buttonLabel = $buttonLabel ?? 'Input Data';
$backUrl = $backUrl ?? url()->current();
@endphp

<a href="{{ route('admin.data-entry.select-patient', ['redirect_to' => $redirectTo, 'back' => $backUrl]) }}" class="btn-primary inline-flex items-center gap-2 text-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    {{ $buttonLabel }}
</a>
@endif
