<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class CheckUserLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // // Get IP address
        // $ip = $request->ip();

        // // Skip local IPs for development
        // if ($ip === '127.0.0.1' || $ip === '::1') {
        //     $request->attributes->set('outside_syria', false);
        //     return $next($request);
        // }

        // // Use a simple IP geolocation API (free, limited requests)
        // $response = Http::get("http://ip-api.com/json/{$ip}?fields=country");

        // $isOutsideSyria = true;

        // if ($response->successful()) {
        //     $country = $response->json('country');
        //     $isOutsideSyria = strtolower($country) !== 'syria';
        // }
        $isOutsideSyria = false;
        // Share with request
        $request->attributes->set('outside_syria', $isOutsideSyria);

        return $next($request);
    }
}
