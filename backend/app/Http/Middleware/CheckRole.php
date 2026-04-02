<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user() && $request->user()->role !== $role) {
            return response()->json(['error' => 'Acesso negado. Apenas para ' . $role], 403);
        }

        return $next($request);
    }
}
