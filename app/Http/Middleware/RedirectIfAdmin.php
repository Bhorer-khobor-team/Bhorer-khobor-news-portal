<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RedirectIfAdmin
{
    // If admin is already logged in, redirect away from login page
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return $next($request);
    }
}

