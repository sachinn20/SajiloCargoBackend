<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        Auth::logout(); 

        // Make sure route('admin.login') exists, or use url('/admin/login')
        return redirect()->route('admin.login')->withErrors([
            'email' => 'Unauthorized access. Admins only.'
        ]);
    }
}
