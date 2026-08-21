<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class EnableDebugForLocalIps
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        $isLocal = filter_var($ip, FILTER_VALIDATE_IP) && (
            str_starts_with($ip, '192.168.') ||
            $ip === '127.0.0.1' ||
            $ip === '::1'
        );

        if ($isLocal) {
            Config::set('app.debug', true);
        }

        return $next($request);
    }
}