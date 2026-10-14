<?php

namespace Oscar\PooPractice\Contracts;

interface SmsNotifier
{
    public function sendSms(string $to, string $message): void;
}