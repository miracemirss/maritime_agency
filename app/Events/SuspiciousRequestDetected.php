<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuspiciousRequestDetected
{
    use Dispatchable, SerializesModels;

    public string $ip;
    public ?int $userId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $ip, ?int $userId = null)
    {
        $this->ip = $ip;
        $this->userId = $userId;
    }
}
