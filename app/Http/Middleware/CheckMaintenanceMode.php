<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (env('MAINTENANCE_MODE', false) === true) {
            return response()->json([
                "success" => false,
                "code" => ResponseCode::SERVICE_UNAVAILABLE,
                "message" => __('errors.service_unavailable'),
                "server_time" => date('Y-m-d H:i:s')
            ], 503);
        }

        return $next($request);
    }
} 