<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\EmailNotifier;

class OrderShippedNotification
{
    public function __construct(private readonly EmailNotifier $emailNotifier)
    {}

    public function notify(string $to, string $message): void
    {
        $this->emailNotifier->sendEmail($to, $message);
    }
}
