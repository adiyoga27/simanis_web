@extends('layouts.app')

@section('title', 'Log System')
@section('page-title', 'Log System')

@section('content')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
.glass-card {
    background: rgba(255, 255, 255, 0.82);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255,255,255,0.55);
    box-shadow: 0 8px 32px rgba(0,0,0,0.05), 0 2px 8px rgba(0,0,0,0.03);
}
.bg-mesh-slate {
    background:
        radial-gradient(at 0% 0%, rgba(99,102,241,0.06) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(139,92,246,0.06) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(59,130,246,0.05) 0px, transparent 50%),
        radial-gradient(at 0% 100%, rgba(99,102,241,0.05) 0px, transparent 50%);
}
.search-input {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
}
.search-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    outline: none;
}
.select-modern {
    transition: all 0.25s ease;
    border: 2px solid #e5e7eb;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.75rem center;
    background-repeat: no-repeat;
    background-size: 1.2em 1.2em;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.select-modern:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.08);
    outline: none;
}
.btn-gradient-indigo {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    transition: all 0.3s ease;
}
.btn-gradient-indigo:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.35);
}
.btn-gradient-indigo:active { transform: translateY(0); }
.btn-export {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    transition: all 0.3s ease;
}
.btn-export:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.35);
}
.table-row-anim {
    animation: fadeInUp 0.35s ease-out forwards;
    opacity: 0;
}
.table-row-modern {
    transition: background-color 0.2s ease, transform 0.15s ease;
}
.table-row-modern:hover {
    background-color: rgba(249, 250, 251, 0.8);
}
.action-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 2px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin-custom {
    animation: spin 1s linear infinite;
}
</style>

<div class="max-w-7xl mx-auto space-y-6 pb-8">

    {{-- Hero Header --}}
    <div class="glass-card rounded-3xl p-6 sm:p-8 bg-mesh-slate">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                </div>
                <div class="pt-0.5">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 leading-tight">Log System</h2>
                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-white/60 text-xs font-semibold text-gray-500 border border-gray-100/60" id="total-info">Memuat...</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">Catatan aktivitas real-time</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.logs.export') }}" id="export-btn" class="btn-export inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-5 py-3.5 shadow-lg shadow-emerald-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="glass-card rounded-2xl p-4 sm:p-5">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-input" placeholder="Cari..." class="search-input w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 placeholder-gray-400">
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <select id="filter-action" class="select-modern px-4 py-3.5 pr-10 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 cursor-pointer min-w-[140px]">
                    <option value="all">Semua Aksi</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                </select>
                <select id="filter-module" class="select-modern px-4 py-3.5 pr-10 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 cursor-pointer min-w-[160px]">
                    <option value="">Semua Module</option>
                    <option value="Auth">Auth</option>
                    <option value="User">User</option>
                    <option value="Assessment">Assessment</option>
                    <option value="Edukasi">Edukasi</option>
                    <option value="Gula Darah">Gula Darah</option>
                    <option value="Screening Kaki">Screening Kaki</option>
                    <option value="Instrument Keyakinan">Instrument</option>
                </select>
                <select id="filter-perpage" class="select-modern px-4 py-3.5 pr-10 rounded-2xl bg-white/70 text-sm font-medium text-gray-700 cursor-pointer min-w-[80px]">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <button onclick="loadLogs()" class="btn-gradient-indigo inline-flex items-center justify-center gap-2 text-sm font-semibold text-white rounded-2xl px-5 py-3.5 shadow-lg shadow-indigo-500/25">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Filter
                </button>
            </div>
        </div>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden md:block glass-card rounded-3xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Module</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody id="log-tbody" class="divide-y divide-gray-50"></tbody>
            </table>
        </div>
        <div id="loading" class="text-center py-12 text-gray-400">
            <div class="w-8 h-8 border-2 border-gray-200 border-t-indigo-500 rounded-full animate-spin-custom mx-auto mb-3"></div>
            <p class="text-sm">Memuat aktivitas...</p>
        </div>
        <div id="empty" class="hidden text-center py-20 text-gray-400">
            <div class="w-20 h-20 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-5 shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#cbd5e1" stroke="none">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <p class="font-bold text-gray-600 text-lg">Tidak ada data</p>
            <p class="text-sm text-gray-400 mt-2">Belum ada aktivitas log yang tercatat.</p>
        </div>
    </div>

    {{-- Mobile List --}}
    <div class="md:hidden space-y-3" id="mobile-list"></div>

    {{-- Pagination --}}
    <div id="pagination" class="flex items-center justify-between text-sm pt-2">
        <span id="page-info" class="text-gray-400 text-xs font-medium"></span>
        <div class="flex items-center gap-1.5" id="page-buttons"></div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    let currentPage = 1;

    const actionColors = {
        login: { bg: '#dcfce7', text: '#166534', border: '#bbf7d0', label: 'Login' },
        logout: { bg: '#f3f4f6', text: '#4b5563', border: '#e5e7eb', label: 'Logout' },
        create: { bg: '#dbeafe', text: '#1d4ed8', border: '#bfdbfe', label: 'Create' },
        update: { bg: '#fef9c3', text: '#a16207', border: '#fde68a', label: 'Update' },
        delete: { bg: '#fee2e2', text: '#b91c1c', border: '#fecaca', label: 'Delete' },
    };

    const moduleIcons = {
        'Auth': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>',
        'User': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
        'Assessment': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>',
        'Edukasi': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
        'Gula Darah': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>',
        'Screening Kaki': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
        'Instrument Keyakinan': '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };

    function formatDateTime(dt) {
        const d = new Date(dt);
        return d.toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    function buildActionBadge(action) {
        const s = actionColors[action] || actionColors.logout;
        let icon = '';
        if (action === 'login') icon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>';
        else if (action === 'logout') icon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>';
        else if (action === 'create') icon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>';
        else if (action === 'update') icon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>';
        else if (action === 'delete') icon = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>';
        return `<span class="action-badge" style="background-color:${s.bg}; color:${s.text}; border:1px solid ${s.border};">${icon} ${s.label}</span>`;
    }

    function updateExportUrl() {
        const params = new URLSearchParams({
            search: document.getElementById('search-input').value,
            filter: document.getElementById('filter-action').value,
            module: document.getElementById('filter-module').value,
        });
        document.getElementById('export-btn').href = `{{ route('admin.logs.export') }}?${params}`;
    }

    function loadLogs(page = 1) {
        currentPage = page;
        updateExportUrl();
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('empty').classList.add('hidden');
        document.getElementById('log-tbody').innerHTML = '';
        document.getElementById('mobile-list').innerHTML = '';

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

                // Desktop table
                let html = '';
                res.data.forEach((log, i) => {
                    const initial = (log.user?.name ?? 'S').substring(0,1).toUpperCase();
                    const name = log.user?.name ?? 'System';
                    const mod = log.module || '-';
                    const modIcon = moduleIcons[mod] || '';
                    html += `<tr class="table-row-anim table-row-modern" style="animation-delay: ${i * 0.03}s">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-extrabold text-gray-500 flex-shrink-0">${initial}</div>
                                <span class="font-medium text-sm text-gray-800">${name}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">${buildActionBadge(log.action)}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-600">${modIcon} <span>${mod}</span></span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 max-w-[280px] truncate" title="${log.description}">${log.description}</td>
                        <td class="px-6 py-4 text-xs text-gray-400 font-mono">${log.ip_address || '-'}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">${formatDateTime(log.created_at)}</td>
                    </tr>`;
                });
                document.getElementById('log-tbody').innerHTML = html;

                // Mobile list
                let mobHtml = '';
                res.data.forEach((log, i) => {
                    const name = log.user?.name ?? 'System';
                    const mod = log.module || '-';
                    const modIcon = moduleIcons[mod] || '';
                    mobHtml += `<div class="glass-card rounded-2xl p-4 table-row-anim" style="animation-delay: ${i * 0.03}s">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-extrabold text-gray-500 flex-shrink-0">${(name).substring(0,1).toUpperCase()}</div>
                                <div>
                                    <p class="font-medium text-sm text-gray-800">${name}</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">${formatDateTime(log.created_at)}</p>
                                </div>
                            </div>
                            ${buildActionBadge(log.action)}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 text-xs text-gray-500">${modIcon} ${mod}</span>
                            <span class="text-xs text-gray-400 font-mono">${log.ip_address || '-'}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-2 truncate" title="${log.description}">${log.description}</p>
                    </div>`;
                });
                document.getElementById('mobile-list').innerHTML = mobHtml;

                document.getElementById('page-info').textContent = `Menampilkan ${res.meta.from}-${res.meta.to} dari ${res.meta.total}`;

                let btns = '';
                for (let i = 1; i <= res.meta.last_page; i++) {
                    btns += `<button onclick="loadLogs(${i})" class="px-3.5 py-2 rounded-xl text-xs font-bold ${i === page ? 'bg-gradient-to-r from-indigo-500 to-violet-500 text-white shadow-md shadow-indigo-200' : 'bg-gray-50 text-gray-500 hover:bg-gray-100'} transition-all duration-200">${i}</button>`;
                }
                document.getElementById('page-buttons').innerHTML = btns;
            });
    }

    document.addEventListener('DOMContentLoaded', () => loadLogs());
    document.getElementById('search-input').addEventListener('keydown', e => { if (e.key === 'Enter') loadLogs(); });
</script>
@endpush