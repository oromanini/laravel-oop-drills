<?php

namespace Oscar\PooPractice\Contracts;

interface EmailNotifier
{
    public function sendEmail(string $to, string $message): void;
}