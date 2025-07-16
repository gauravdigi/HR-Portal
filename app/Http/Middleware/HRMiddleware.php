<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HRMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next)
{
    $role = auth()->user()->role;
    \Log::info("User role: $role"); // Log the role for debugging purposes

    if (auth()->check() && $role === 'hr') {
        return $next($request);
    }

    abort(403, 'Unauthorized.');
}
}
