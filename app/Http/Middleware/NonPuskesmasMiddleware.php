<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonPuskesmasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role !== 'kepala_puskesmas') {
            return $next($request);
        }

        return redirect()->back()->with('error', 'Akses ditolak. Kepala Puskesmas hanya dapat melihat data monitoring.');
    }
}
