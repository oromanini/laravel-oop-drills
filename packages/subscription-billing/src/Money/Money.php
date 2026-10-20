<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Money;

use InvalidArgumentException;

final class Money
{
    private const int PERCENT_DIVISOR = 100;
    private const int HALF_OF_PERCENT_DIVISOR = self::PERCENT_DIVISOR / 2;

    private function __construct(
        private readonly int $cents,
        private readonly Currency $currency,
    ) {
        $this->validateCentsAreNotNegative($cents);
    }

    public static function fromCents(int $cents, Currency $currency): self
    {
        return new self($cents, $currency);
    }

    public function cents(): int
    {
        return $this->cents;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    private function validateCentsAreNotNegative(int $cents): void
    {
        if ($cents < 0) {
            throw new InvalidArgumentException(
                "The value does not be negative."
            );
        }
    }

    public function subtract(Money $moneyB): self
    {
        $this->currency !== $moneyB->currency()
        && throw new InvalidArgumentException('Currencies must be the same.');

        $cents = $this->cents - $moneyB->cents();

        return new self($cents, $this->currency);
    }

    public function percentage(int $percent): self
    {
        $scaled = $this->cents * $percent;
        $rounded = intdiv(
            num1: $scaled + self::HALF_OF_PERCENT_DIVISOR,
            num2: self::PERCENT_DIVISOR
        );

        return new self($rounded, $this->currency);
    }
}
