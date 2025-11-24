<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan
        // $roles adalah array dari parameter middleware (misal: ['Admin', 'NOC'])
        if (! in_array($request->user()->role, $roles)) {
            // Jika tidak punya akses, tampilkan error 403 (Forbidden)
            abort(403, 'Unauthorized action. Your role (' . $request->user()->role . ') does not have access.');
        }

        return $next($request);
    }
}