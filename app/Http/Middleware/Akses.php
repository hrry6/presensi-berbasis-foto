<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Akses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedRoles = [1, 2, 3, 4, 5, 6];

        if (Auth::user() && in_array(Auth::user()->id_role, $allowedRoles)) {
            return $next($request);
        }

        return redirect()->route('auth.login');
    }
}
