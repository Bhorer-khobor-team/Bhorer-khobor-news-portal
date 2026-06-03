<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Not logged in? Redirect to login page
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }


        $admin = Auth::guard('admin')->user();


        // Account deactivated? Logout and redirect with error
        if (!$admin->is_active) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your account has been deactivated.']);
        }


        // Account locked? Logout and redirect with error
        if ($admin->is_locked) {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your account has been locked.']);
        }


        return $next($request);
    }
}

