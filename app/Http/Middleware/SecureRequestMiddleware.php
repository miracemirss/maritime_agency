<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\SecurityTools;

class SecureRequestMiddleware
{
    use SecurityTools;

    public function handle(Request $request, Closure $next)
    {
        // Sadece POST, PUT, PATCH isteklerinde kontrol et
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $next($request);
        }

        // Sadece güvenlik kontrolü yapılacak alanlar
        $fieldsToCheck = ['notes', 'description', 'message', 'comment', 'content'];

        $suspiciousFields = collect($request->only($fieldsToCheck))->filter(function ($value) {
            return $value && $this->blockMaliciousWords(['text' => $value]);
        });

        if ($suspiciousFields->isNotEmpty()) {
            Log::warning('Şüpheli içerik bulundu', [
                'fields' => $suspiciousFields->keys(),
                'ip' => $request->ip()
            ]);
            return response()->json(['message' => 'Şüpheli içerik algılandı.'], 400);
        }

        // İstek bilgisini logla (isteğe bağlı)
        $this->logSecurityRequest($request, 'Güvenlik Logu');

        return $next($request);
    }
}
