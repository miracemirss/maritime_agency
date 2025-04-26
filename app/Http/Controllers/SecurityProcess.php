<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class SecurityProcess extends Controller
{
    /**
     * Belirli kelimeleri temizleyen input filtresi
     */
    public function inputClear(...$inputs): array
    {
        $blockedWords = [
            'performance_scheme', '<script>', '</script>', '<php', '?>',
            'ships', 'personnel', 'spare', 'services', 'transits', 'cache'
        ];

        return array_map(function ($input) use ($blockedWords) {
            foreach ($blockedWords as $word) {
                $input = str_replace($word, '', $input);
            }
            return $input;
        }, $inputs);
    }

    /**
     * XSS korumalı input temizleme
     */
    public function sanitizeInput(string $input): string
    {
        $input = strip_tags($input);
        return Purifier::clean($input);
    }

    /**
     * Dizi halinde gelen inputları temizle
     */
    public function sanitizeArray(array $inputs): array
    {
        return array_map(function ($item) {
            return is_string($item) ? $this->sanitizeInput($item) : $item;
        }, $inputs);
    }

    /**
     * İstek methodunu kontrol et
     */
    public function methodIs(Request $request, string $method): bool
    {
        return strtolower($request->method()) === strtolower($method);
    }

    /**
     * Oturum kontrolü (basic)
     * Not: Auth::check() daha profesyonel kullanım sağlar
     */
    public function sessionControl(Request $request)
    {
        if (!$request->session()->has('user_id')) {
            return view('home')->with('message', 'Oturum kontrolü başarısız');
        }

        return view('dashboard')->with([
            'message' => 'Giriş başarılı',
            'user_id' => $request->session()->get('user_id')
        ]);
    }

    /**
     * İstek loglama
     */
    public function logRequest(Request $request, string $action = 'Request'): void
    {
        $user = Auth::user();
        Log::info("{$action} by " . ($user?->email ?? 'guest') . ' from IP: ' . $request->ip(), [
            'user_agent' => $request->userAgent(),
            'uri' => $request->path(),
            'data' => $request->all(),
        ]);
    }

    /**
     * Zararlı içerik kontrolü (blacklist kelimelere karşı)
     */
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
}
