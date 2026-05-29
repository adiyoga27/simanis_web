<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminLogController extends Controller
{
    public function index()
    {
        return view('admin.logs.index');
    }

    public function data(Request $request)
    {
        $query = $this->buildQuery($request);

        $logs = $query->paginate($request->get('per_page', 25));

        return response()->json([
            'data' => $logs->items(),
            'meta' => [
                'current_page' => $logs->currentPage(),
                'last_page'    => $logs->lastPage(),
                'total'        => $logs->total(),
                'from'         => $logs->firstItem(),
                'to'           => $logs->lastItem(),
            ],
        ]);
    }

    public function export(Request $request)
    {
        $query = $this->buildQuery($request);
        $logs = $query->get();

        $filename = 'log-system-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fprintf($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, ['No', 'User', 'Aksi', 'Module', 'Deskripsi', 'IP Address', 'Waktu']);

            $rows = $logs->map(function ($log, $i) {
                return [
                    $i + 1,
                    $log->user?->name ?? 'System',
                    $log->action,
                    $log->module ?? '-',
                    $log->description,
                    $log->ip_address ?? '-',
                    $log->created_at->format('d/m/Y H:i:s'),
                ];
            });

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    private function buildQuery(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($filter = $request->get('filter')) {
            if ($filter !== 'all') {
                $query->where('action', $filter);
            }
        }

        if ($module = $request->get('module')) {
            $query->where('module', $module);
        }

        if ($user = $request->get('user_id')) {
            $query->where('user_id', $user);
        }

        return $query;
    }
}
