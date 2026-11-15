<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PastikanAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->adalahAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini khusus Administrator.');
        }

        return $next($request);
    }
}
