<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::guard('web')->check()) {
            return redirect()->route('userLogin')->with('error', 'Please log in as a user.');
        }

        // Ensure admin users don't access user routes
        if (Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Admin users cannot access user pages.');
        }

        return $next($request);
    }
}
