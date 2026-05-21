@extends('layouts.app')

@section('title', 'Monitoring Diabetes Kaki')
@section('page-title', 'Monitoring Diabetes Kaki')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Diabetes Kaki</h2>
            <p class="text-sm text-gray-400 mt-0.5">{{ $results->total() }} assessment · semua pengguna</p>
        </div>
        <form method="GET" class="relative">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari user..."
                class="input-field !py-2 !pl-9 !pr-4 !w-56">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </form>
    </div>

    <div class="card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">User</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Total Skor</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Aturan Cocok</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($results as $r)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ strtoupper(substr($r->user?->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $r->user?->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">&#64;{{ $r->user?->username ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="badge {{ $r->total_score > 6 ? 'badge-red' : ($r->total_score > 3 ? 'badge-yellow' : 'badge-green') }}">
                                {{ $r->total_score }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-gray-600">{{ is_array($r->matched_rules) ? count($r->matched_rules) : 0 }} aturan</td>
                        <td class="px-5 py-4 text-gray-500 text-xs">{{ $r->created_at->format('d M Y · H:i') }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('admin.assessments.result.detail', [$r->user_id, $r->id]) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary-50 text-primary-700 text-xs font-semibold hover:bg-primary-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($results->isEmpty())
            <div class="text-center py-12 text-gray-400 text-sm">Tidak ada data.</div>
        @endif
    </div>

    <div class="px-1">
        {{ $results->links() }}
    </div>

</div>
@endsection
