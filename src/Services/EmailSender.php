<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\EmailNotifier;

class EmailSender implements EmailNotifier
{

    public function sendEmail(string $to, string $message): void
    {
        echo "Email to {$to}: {$message}" . PHP_EOL;
    }
}