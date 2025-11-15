<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTelescope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('telescope')) {
            $authCheck = auth()->guard('admin')->check();
            if (!$authCheck) {
                return redirect()->route('admin.dashboard')->with('error', 'Access Denied.');
            }
        }
        return $next($request);
    }
}
