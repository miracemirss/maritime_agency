<?php

namespace App\Listeners;

use App\Events\SuspiciousRequestDetected;
use Illuminate\Support\Facades\Cache;

class BanSuspiciousIpListener
{
    // Kaç şüpheli istekten sonra IP banlanacak
    private int $threshold = 5;

    // IP ban süresi (saniye cinsinden)
    private int $banDuration = 3600; // 1 saat

    /**
     * Handle the event.
     */
    public function handle(SuspiciousRequestDetected $event): void
    {
        if (!$event->ip) {
            return;
        }

        $ip = $event->ip;
        $countKey = "suspicious_ip:" . $ip;
        $banKey = "banned_ip:" . $ip;

        // Şüpheli istek sayısını bir artır
        $attempts = Cache::increment($countKey);

        // Eğer bu IP için sayaç yoksa, yeni başlıyoruz demektir => Süre koy
        if ($attempts === 1) {
            Cache::put($countKey, 1, $this->banDuration);
        }

        // Eğer şüpheli istek sayısı eşik değerine ulaşırsa IP'yi banla
        if ($attempts >= $this->threshold) {
            Cache::put($banKey, true, $this->banDuration);
            Cache::forget($countKey); // Sayacı sıfırla
        }
    }
}
