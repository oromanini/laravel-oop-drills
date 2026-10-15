<?php

namespace Oscar\PooPractice\Services;

class OrderShippedNotificationOld
{
    public function notify(string $to, string $message): void
    {
        $emailSender = new EmailSender();
        $emailSender->sendEmail($to, $message);
    }
}