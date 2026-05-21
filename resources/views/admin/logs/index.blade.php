@extends('layouts.app')

@section('title', 'Log System')
@section('page-title', 'Log System')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Aktivitas Log</h2>
            <p class="text-sm text-gray-400 mt-0.5" id="total-info">Memuat...</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card !py-3">
        <div class="flex flex-wrap items-center gap-3">
            <input type="text" id="search-input" placeholder="Cari..." class="input-field !py-2 !w-48 text-sm">
            <select id="filter-action" class="input-field !py-2 !w-36 text-sm">
                <option value="all">Semua Aksi</option>
                <option value="login">Login</option>
                <option value="logout">Logout</option>
                <option value="create">Create</option>
                <option value="update">Update</option>
                <option value="delete">Delete</option>
            </select>
            <select id="filter-module" class="input-field !py-2 !w-40 text-sm">
                <option value="">Semua Module</option>
                <option value="Auth">Auth</option>
                <option value="User">User</option>
                <option value="Assessment">Assessment</option>
                <option value="Edukasi">Edukasi</option>
                <option value="Gula Darah">Gula Darah</option>
                <option value="Screening Kaki">Screening Kaki</option>
                <option value="Instrument Keyakinan">Instrument</option>
            </select>
            <select id="filter-perpage" class="input-field !py-2 !w-24 text-sm">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <button onclick="loadLogs()" class="btn-primary text-sm !py-2">Filter</button>
        </div>
    </div>

    <div class="card overflow-hidden !p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">User</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Aksi</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Module</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Deskripsi</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">IP</th>
                        <th class="px-5 py-3.5 font-semibold text-gray-500 text-xs uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody id="log-tbody" class="divide-y divide-gray-50"></tbody>
            </table>
        </div>
        <div id="loading" class="text-center py-8 text-gray-400 text-sm">Memuat...</div>
        <div id="empty" class="text-center py-8 text-gray-400 text-sm hidden">Tidak ada data.</div>
    </div>

    {{-- Pagination --}}
    <div id="pagination" class="flex items-center justify-between text-sm">
        <span id="page-info" class="text-gray-400"></span>
        <div class="flex items-center gap-1" id="page-buttons"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;

    function loadLogs(page = 1) {
        currentPage = page;
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('empty').classList.add('hidden');
        document.getElementById('log-tbody').innerHTML = '';

        const params = new URLSearchParams({
            search: document.getElementById('search-input').value,
            filter: document.getElementById('filter-action').value,
            module: document.getElementById('filter-module').value,
            per_page: document.getElementById('filter-perpage').value,
            page: page
        });

        fetch(`{{ route('admin.logs.data') }}?${params}`)
            .then(r => r.json())
            .then(res => {
                document.getElementById('loading').classList.add('hidden');
                document.getElementById('total-info').textContent = `${res.meta.total} aktivitas`;

                if (!res.data.length) {
                    document.getElementById('empty').classList.remove('hidden');
                    return;
                }

                const actionColors = { login: 'bg-green-100 text-green-700', logout: 'bg-gray-100 text-gray-600', create: 'bg-blue-100 text-blue-700', update: 'bg-yellow-100 text-yellow-700', delete: 'bg-red-100 text-red-700' };

                let html = '';
                res.data.forEach(log => {
                    html += `<tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            <span class="font-medium text-gray-800">${log.user?.name ?? 'System'}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold ${actionColors[log.action] || 'bg-gray-100 text-gray-600'}">${log.action}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs">${log.module || '-'}</td>
                        <td class="px-5 py-3 text-gray-600 max-w-[300px] truncate" title="${log.description}">${log.description}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs font-mono">${log.ip_address || '-'}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs whitespace-nowrap">${new Date(log.created_at).toLocaleString('id-ID')}</td>
                    </tr>`;
                });
                document.getElementById('log-tbody').innerHTML = html;

                document.getElementById('page-info').textContent = `Menampilkan ${res.meta.from}-${res.meta.to} dari ${res.meta.total}`;

                let btns = '';
                for (let i = 1; i <= res.meta.last_page; i++) {
                    btns += `<button onclick="loadLogs(${i})" class="px-3 py-1 rounded-lg text-xs font-semibold ${i === page ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'} transition-colors">${i}</button>`;
                }
                document.getElementById('page-buttons').innerHTML = btns;
            });
    }

    document.addEventListener('DOMContentLoaded', () => loadLogs());
    document.getElementById('search-input').addEventListener('keydown', e => { if (e.key === 'Enter') loadLogs(); });
</script>
@endpush
