<?php

namespace Oscar\PooPractice\Contracts;

interface PushNotifier
{
    public function sendPush(string $to, string $message): void;
}