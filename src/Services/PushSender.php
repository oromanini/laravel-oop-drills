<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\PushNotifier;

class PushSender implements PushNotifier
{
    public function sendPush(string $to, string $message): void
    {
        echo "Push notification to {$to}: {$message}" . PHP_EOL;
    }
}