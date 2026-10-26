<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Payments;

use InvalidArgumentException;

final class PaymentResult
{
    private function __construct(
        private readonly bool $isSuccessful,
        private readonly ?string $transactionId,
        private readonly ?string $failureReason,
    ) {
        $this->validate();
    }

    public static function succeeded(string $transactionId): PaymentResult
    {
        return new self(
            isSuccessful: true,
            transactionId: $transactionId,
            failureReason: null
        );
    }

    public static function declined(string $failureReason): PaymentResult
    {
        return new self(
            isSuccessful: false,
            transactionId: null,
            failureReason: $failureReason
        );
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }

    public function transactionId(): ?string
    {
        return $this->transactionId;
    }

    public function failureReason(): ?string
    {
        return $this->failureReason;
    }

    private function validate(): void
    {
        $assertNotBlank = static fn (?string $value, string $message)
        => ($value !== null && trim($value) === '')
            && throw new InvalidArgumentException($message);

        $assertNotBlank($this->transactionId, 'Transaction ID must not be empty.');
        $assertNotBlank($this->failureReason, 'Failure reason must not be empty.');
    }
}
