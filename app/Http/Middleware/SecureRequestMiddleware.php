<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\SecurityTools;
use App\Events\SuspiciousRequestDetected;

class SecureRequestMiddleware
{
    use SecurityTools;

    public function handle(Request $request, Closure $next)
    {
        // Sadece POST, PUT, PATCH isteklerinde çalış
        if (!in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $next($request);
        }

        // 1. ADIM: Gelen ham veride şüpheli içerik var mı kontrol et (Temizlenmeden önce)
        $rawInputs = $request->all();
        $flattenedRawInputs = $this->flattenArray($rawInputs);

        foreach ($flattenedRawInputs as $key => $value) {
            if (is_string($value) && $this->blockMaliciousPatterns([$value])) {
                // Şüpheli içerik bulundu!

                // Event tetikle (Şüpheli istek yakalandı)
                event(new SuspiciousRequestDetected(
                    $request->ip(),
                    $request->user()?->id
                ));

                // Log kaydı al
                $this->logSecurityRequest($request, "Suspicious RAW Input Blocked in field: $key");

                // Hatalı cevap dön
                return response()->json([
                    'message' => "Şüpheli içerik tespit edildi: $key alanında uygunsuz veri bulundu."
                ], 400);
            }
        }

        // 2. ADIM: Temizleme yap (deep sanitize)
        $sanitizedInputs = $this->deepSanitizeArray($rawInputs, 'strict');
        $request->merge($sanitizedInputs);

        // 3. ADIM: Normal akışı devam ettir
        return $next($request);
    }

    /**
     * Çok boyutlu arrayleri düzleştirir.
     */
    private function flattenArray(array $array): array
    {
        $result = [];

        array_walk_recursive($array, function ($a, $b) use (&$result) {
            $result[$b] = $a;
        });

        return $result;
    }
}
