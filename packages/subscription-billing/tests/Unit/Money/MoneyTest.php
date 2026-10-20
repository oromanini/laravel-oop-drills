<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Money;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Money::class)]
class MoneyTest extends TestCase
{
    #[Test]
    public function exposesCentsAndCurrencyItWasCreatedWith(): void
    {

        $money = Money::fromCents(1999, Currency::BRL);

        $this->assertSame(
            expected: 1999,
            actual: $money->cents()
        );

        $this->assertSame(
            expected: Currency::BRL,
            actual: $money->currency()
        );
    }

    #[Test]
    public function refusesNegativeCents(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains("The value does not be negative.");
        Money::fromCents(-4, Currency::BRL);
    }

    #[Test]
    public function subtractsAmountsOfTheSameCurrency(): void
    {
        $moneyA = Money::fromCents(1000, Currency::BRL);
        $moneyB = Money::fromCents(400, Currency::BRL);

        $moneyC = $moneyA->subtract($moneyB);

        $this->assertSame(expected: 600, actual: $moneyC->cents());
        $this->assertSame(expected: 1000, actual: $moneyA->cents());
        $this->assertSame(expected: 400, actual: $moneyB->cents());
    }

    #[Test]
    public function refusesToSubtractDifferentCurrencies(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains("Currencies must be the same.");

        $moneyA = Money::fromCents(1000, Currency::BRL);
        $moneyB = Money::fromCents(400, Currency::EUR);

        $moneyA->subtract($moneyB);
    }

    #[Test]
    public function refusesToSubtractWhenResultWouldBeNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains("The value does not be negative.");

        $moneyA = Money::fromCents(1000, Currency::BRL);
        $moneyB = Money::fromCents(1100, Currency::BRL);

        $moneyA->subtract($moneyB);
    }

    #[Test]
    #[DataProvider('roundScenarios')]
    public function roundsHalfUpWhenApplyingAPercentage(
        int $cents,
        int $expected,
        int $percent
    ): void {
        $money = Money::fromCents($cents, Currency::BRL);

        $this->assertSame(
            expected: $expected,
            actual: $money->percentage($percent)->cents()
        );

    }

    public static function roundScenarios(): array
    {
        return [
            'rounds up above half' => [
                'cents' => 1999,
                'expected' => 200,
                'percent' => 10,
            ],
            'rounds up exactly at half' => [
                'cents' => 5,
                'expected' => 1,
                'percent' => 10,
            ],
            'rounds down below half' => [
                'cents' => 4,
                'expected' => 0,
                'percent' => 10,
            ],
        ];
    }

    #[Test]
    public function keepsTheCurrencyAndLeavesTheOriginalUntouchedWhenApplyingAPercentage(): void
    {
        $originalCents = 1999;
        $money = Money::fromCents($originalCents, Currency::EUR);

        $money2 = $money->percentage(10);

        $this->assertSame(Currency::EUR, $money2->currency());
        $this->assertSame($money->cents(), $originalCents);
    }
}
