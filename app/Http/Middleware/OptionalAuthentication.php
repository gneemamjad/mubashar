<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;

class OptionalAuthentication extends Authenticate
{
    protected function authenticate($request, array $guards)
    {
        try {
            parent::authenticate($request, $guards);
        } catch (\Exception $e) {
            // Do nothing if authentication fails
            return;
        }
    }
}
