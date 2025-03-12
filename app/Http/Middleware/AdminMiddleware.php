<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')->with('error', 'Please log in as an admin.');
        }

        // Prevent normal users from accessing admin routes
        if (Auth::guard('web')->check()) {
            return redirect()->route('userLogin')->with('error', 'Normal users cannot access admin pages.');
        }
        return $next($request);
    }
}
