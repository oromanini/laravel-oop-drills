<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Discount\PercentageDiscount;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(PercentageDiscount::class)]
class PercentageDiscountTest extends TestCase
{
    #[Test]
    #[DataProvider('percentageDiscountScenarios')]
    public function appliesThePercentageOffThePrice(
        int $priceCents,
        int $percent,
        int $expectedCents
    ): void {
        $value = Money::fromCents($priceCents, Currency::BRL);
        $percentageDiscount = new PercentageDiscount($percent);
        $afterDiscount = $percentageDiscount->apply($value);

        $this->assertSame(
            expected: $expectedCents,
            actual: $afterDiscount->cents()
        );
        $this->assertSame(
            expected: Currency::BRL,
            actual: $afterDiscount->currency(),
        );
    }

    public static function percentageDiscountScenarios(): array
    {
        return [
            'ten percent off' => [
                'priceCents' => 1999,
                'percent' => 10,
                'expectedCents' => 1799,
            ],
            'zero percent leaves the price untouched' => [
                'priceCents' => 1000,
                'percent' => 0,
                'expectedCents' => 1000,
            ],
            'one hundred percent makes it free' => [
                'priceCents' => 1000,
                'percent' => 100,
                'expectedCents' => 0,
            ],
        ];
    }

    #[Test]
    #[DataProvider('percentageDiscountInvalidScenarios')]
    public function refusesAPercentOutsideZeroToOneHundred(int $percent): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains(
            'Discount percent must be between 0 and 100.',
        );

        new PercentageDiscount($percent);
    }

    public static function percentageDiscountInvalidScenarios(): array
    {
        return [
            'negative percent' => [
                'percent' => -1,
            ],
            'greater than one hundred' => [
                'percent' => 101,
            ],
        ];
    }
}
