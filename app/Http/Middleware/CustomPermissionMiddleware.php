<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Auth;

class CustomPermissionMiddleware
{
    public function handle($request, Closure $next, $permission, $guard = null)
    {
        $authGuard = Auth::guard($guard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $permissions = is_array($permission)
            ? $permission
            : explode('|', $permission);

        // Check if the permission exists and user has it
        foreach ($permissions as $permission) {
            if ($authGuard->user()->hasPermissionTo($permission, $guard)) {
                return $next($request);
            }
        }

        throw UnauthorizedException::forPermissions($permissions);
    }
} 