<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class IpBanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();
        $banKey = "banned_ip:" . $ip;

        if (Cache::has($banKey)) {
            return response()->json([
                'message' => 'Erişim engellendi. IP adresiniz banlanmıştır.'
            ], Response::HTTP_FORBIDDEN); // 403 Forbidden
        }

        return $next($request);
    }
}
