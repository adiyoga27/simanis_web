<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperadminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'superadmin') {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak. Hanya Superadmin yang dapat mengakses.');
    }
}
