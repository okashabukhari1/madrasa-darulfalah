<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacher
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->isTeacher()) {
            if (auth()->user()->isAdmin()) {
                return redirect('/admin/dashboard');
            }
            if (auth()->user()->isStudent()) {
                return redirect('/student/dashboard');
            }
            abort(403, 'Access denied. Teacher account required.');
        }

        return $next($request);
    }
}
