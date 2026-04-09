<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudent
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isStudent()) {
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect('/admin/dashboard');
            }
            abort(403, 'Access denied. Student account required.');
        }
        return $next($request);
    }
}
