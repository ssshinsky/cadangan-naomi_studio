<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            if ($role === 'admin') {
                abort(403, 'Akses ditolak. Halaman ini hanya untuk admin.');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
