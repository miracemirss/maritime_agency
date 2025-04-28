<?php

namespace App\Listeners;

use App\Events\SuspiciousRequestDetected;
use Illuminate\Support\Facades\Log;

class LogSuspiciousRequestListener
{
    /**
     * Handle the event.
     */
    public function handle(SuspiciousRequestDetected $event): void
    {
        Log::channel('security')->warning('Şüpheli istek tespit edildi.', [
            'ip' => $event->ip,
            'user_id' => $event->userId,
            'detected_at' => now()->toDateTimeString(),
        ]);
    }
}
