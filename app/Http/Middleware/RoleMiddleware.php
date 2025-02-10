<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = Auth::user();

        if (!$user || ($role === 'admin' && !$user->role)) {
            return redirect('/login')->withErrors(['role' => 'Bạn không có quyền truy cập.']);
        }
        
        return $next($request);
    }
}
