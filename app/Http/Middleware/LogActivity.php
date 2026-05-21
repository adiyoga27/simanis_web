<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $this->logRequest($request, $response);

        return $response;
    }

    protected function logRequest(Request $request, $response): void
    {
        if (!$this->shouldLog($request)) return;

        $action = match ($request->method()) {
            'POST'   => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default  => null,
        };

        if (!$action) return;

        $module = $this->detectModule($request);
        $description = $this->buildDescription($request, $action, $module);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'metadata'    => [
                'url'     => $request->fullUrl(),
                'method'  => $request->method(),
                'input'   => $request->except(['password', 'password_confirmation', '_token', '_method']),
                'route'   => $request->route()?->getName(),
            ],
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);
    }

    protected function shouldLog(Request $request): bool
    {
        $exclude = ['_debugbar', 'telescope', 'sanctum', 'broadcasting'];
        foreach ($exclude as $path) {
            if (str_contains($request->path(), $path)) return false;
        }
        return in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);
    }

    protected function detectModule(Request $request): string
    {
        $path = $request->path();
        $segments = explode('/', trim($path, '/'));

        if (str_contains($path, 'admin/instruments')) return 'Instrument Keyakinan';
        if (str_contains($path, 'admin/education')) return 'Edukasi';
        if (str_contains($path, 'admin/assessments')) return 'Assessment';
        if (str_contains($path, 'admin/monitoring')) return 'Monitoring';
        if (str_contains($path, 'admin/users')) return 'User';
        if (str_contains($path, 'admin')) return 'Admin';
        if (str_contains($path, 'assessment')) return 'Assessment Kaki';
        if (str_contains($path, 'instrument')) return 'Instrument Keyakinan';
        if (str_contains($path, 'blood-sugar')) return 'Gula Darah';
        if (str_contains($path, 'foot-screening')) return 'Screening Kaki';
        if (str_contains($path, 'tnt')) return 'TNT';
        if (str_contains($path, 'medications')) return 'Obat';
        if (str_contains($path, 'education')) return 'Edukasi';
        if (str_contains($path, 'profile')) return 'Profile';
        if (str_contains($path, 'register')) return 'Auth';
        if (str_contains($path, 'login')) return 'Auth';
        if (str_contains($path, 'logout')) return 'Auth';

        return $segments[0] ?? 'System';
    }

    protected function buildDescription(Request $request, string $action, string $module): string
    {
        $user = Auth::user()?->name ?? 'System';
        $labels = ['create' => 'menambah', 'update' => 'mengubah', 'delete' => 'menghapus'];

        return "{$user} {$labels[$action]} data di {$module}";
    }
}
