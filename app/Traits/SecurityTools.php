<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

trait SecurityTools
{
    /**
     * Temel veya sıkı modda input sanitize eder.
     */
    public function sanitizeInput(string $input, string $mode = 'basic'): string
    {
        $input = strip_tags($input);

        if ($mode === 'strict') {
            $config = ['HTML.Allowed' => '']; // Hiç HTML etiketi izin verilmez
            return Purifier::clean($input, $config);
        }

        return Purifier::clean($input);
    }

    /**
     * Dizi veya nested array'i temizler.
     */
    public function deepSanitizeArray(array $inputs, string $mode = 'basic'): array
    {
        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                $inputs[$key] = $this->deepSanitizeArray($value, $mode);
            } elseif (is_string($value)) {
                $inputs[$key] = $this->sanitizeInput($value, $mode);
            }
        }

        return $inputs;
    }

    /**
     * Şüpheli içerik tespiti yapar (pattern veya kelime).
     */
    public function blockMaliciousPatterns(array $inputs): bool
    {
        $patterns = config('securitytools.patterns', [
            '/<script.*?>.*?<\/script>/i',
            '/(DROP TABLE|UNION SELECT|<\?php|\?>)/i',
            '/(select\s+.*from|insert\s+into|update\s+.*set|delete\s+from)/i'
        ]);

        foreach ($inputs as $value) {
            if (is_array($value)) {
                if ($this->blockMaliciousPatterns($value)) {
                    return true;
                }
            } elseif (is_string($value)) {
                foreach ($patterns as $pattern) {
                    if (preg_match($pattern, strtolower($value))) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Güvenlik logu atar.
     */
    public function logSecurityRequest(Request $request, string $action = 'Request')
    {
        Log::channel('security')->info("{$action} by " . ($request->user()?->email ?? 'guest'), [
            'user_id' => $request->user()?->id ?? null,
            'ip' => $request->ip(),
            'method' => $request->method(),
            'path' => $request->path(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
