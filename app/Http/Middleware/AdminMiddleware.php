<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = ['superadmin', 'kepala_puskesmas', 'kepala_desa', 'kader'];

        if (Auth::check() && in_array(Auth::user()->role, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('foot-screening')->with('error', 'Akses ditolak.');
    }
}
