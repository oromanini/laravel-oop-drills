<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\EmailNotifier;

class FakeEmailSender implements EmailNotifier
{

    public function sendEmail(string $to, string $message): void
    {
        echo "[FAKE] Email to {$to}: {$message}" . PHP_EOL;

    }
}