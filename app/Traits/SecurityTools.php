<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

trait SecurityTools
{
    public function sanitizeInput(string $input): string
    {
        return Purifier::clean(strip_tags($input));
    }

    public function sanitizeArray(array $inputs): array
    {
        return array_map(function ($item) {
            return is_string($item) ? $this->sanitizeInput($item) : $item;
        }, $inputs);
    }

    public function blockMaliciousWords(array $inputs, array $blacklist = []): bool
    {
        $blacklist = $blacklist ?: ['<script>', '</script>', '<?php', '?>', 'DROP TABLE', 'UNION SELECT'];
        foreach ($inputs as $value) {
            foreach ($blacklist as $word) {
                if (is_string($value) && Str::contains(strtolower($value), strtolower($word))) {
                    return true;
                }
            }
        }
        return false;
    }

    public function logSecurityRequest(Request $request, string $action = 'Request')
    {
        Log::info("{$action} by " . ($request->user()?->email ?? 'guest'), [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'path' => $request->path(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
