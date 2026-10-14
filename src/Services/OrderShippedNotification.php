<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\EmailNotifier;

class OrderShippedNotification
{
    public function __construct(private readonly EmailNotifier $notifier)
    {}

    public function notify(string $to, string $message): void {
        $this->notifier->sendEmail($to, $message);
    }
}