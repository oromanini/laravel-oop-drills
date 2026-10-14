<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\SmsNotifier;

class SmsSender implements SmsNotifier
{
    public function sendSms(string $to, string $message): void
    {
        echo "SMS to {$to}: {$message}" . PHP_EOL;
    }
}