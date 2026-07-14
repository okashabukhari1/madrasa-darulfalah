<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role ?? null;

        if (!$userRole || (count($roles) > 0 && !in_array($userRole, $roles, true))) {
            abort(403, 'Access denied. Role not permitted.');
        }

        return $next($request);
    }
}

