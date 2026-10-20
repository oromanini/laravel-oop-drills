<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Discount\FixedDiscount;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(FixedDiscount::class)]
class FixedDiscountTest extends TestCase
{
    #[Test]
    #[DataProvider('fixedDiscountScenarios')]
    public function appliesTheFixedOffThePrice(
        int $discountCents,
        int $expectedCents,
    ): void {
        $price = Money::fromCents(10000, Currency::BRL);
        $rule = new FixedDiscount($discountCents);

        $this->assertSame($expectedCents, $rule->apply($price)->cents());
    }

    public static function fixedDiscountScenarios(): array
    {
        return [
            'a regular fixed amount' => [
                'discountCents' => 2000,
                'expectedCents' => 8000,
            ],
            'exactly on the limit' => [
                'discountCents' => 3000,
                'expectedCents' => 7000,
            ],
            'zero amount leaves the price untouched' => [
                'discountCents' => 0,
                'expectedCents' => 10000,
            ],
        ];
    }

    #[Test]
    #[DataProvider('refusedFixedDiscountScenarios')]
    public function refusesTheFixedOffThePrice(
        int $discountCents,
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Fixed discount must not exceed 30% of the price.');

        $price = Money::fromCents(10000, Currency::BRL);
        $rule = new FixedDiscount($discountCents);

        $rule->apply($price);
    }

    public static function refusedFixedDiscountScenarios(): array
    {
        return [
            'above the limit' => [
                'discountCents' => 5000,
            ],
            'just above the limit' => [
                'discountCents' => 3001,
            ],
            'more than the price' => [
                'discountCents' => 20000,
            ],
        ];
    }

    #[Test]
    public function allowsPricingZero(): void
    {
        $money = Money::fromCents(0, Currency::BRL);
        $rule = new FixedDiscount(0);
        $result = $rule->apply($money);

        $this->assertSame(expected: 0, actual: $result->cents());
    }

    #[Test]
    public function refusesPricingZeroWithDiscount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Fixed discount must not exceed 30% of the price.');

        $money = Money::fromCents(0, Currency::BRL);
        $rule = new FixedDiscount(10);

        $rule->apply($money);
    }
}
