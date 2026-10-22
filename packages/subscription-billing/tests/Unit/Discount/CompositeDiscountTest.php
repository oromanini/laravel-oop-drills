<?php

declare (strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Discount\CompositeDiscount;
use Oscar\SubscriptionBilling\Discount\FixedDiscount;
use Oscar\SubscriptionBilling\Discount\PercentageDiscount;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompositeDiscount::class)]
class CompositeDiscountTest extends TestCase
{
    #[Test]
    #[DataProvider('compositeDiscountScenarios')]
    public function appliesCompositeDiscount(array $rules, int $expected): void
    {
        $money = Money::fromCents(10000, Currency::BRL);
        $compositeDiscount = new CompositeDiscount($rules);

        $this->assertSame(($compositeDiscount->apply($money))->cents(), $expected);
    }

    public static function compositeDiscountScenarios(): array
    {
        return [
            'applies the rules in sequence' => [
                'rules' => [
                    new PercentageDiscount(10),
                    new FixedDiscount(1000)
                ],
                'expected' => 8000,
            ],
            'order changes the result' => [
                'rules' => [
                    new FixedDiscount(1000),
                    new PercentageDiscount(10),
                ],
                'expected' => 8100,
            ],
            'no rules leaves the price untouched' => [
                'rules' => [],
                'expected' => 10000,
            ],
        ];
    }

    #[Test]
    public function refusesCompositeDiscount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Fixed discount must not exceed 30% of the price.');

        $money = Money::fromCents(10000, Currency::BRL);
        $compositeDiscount = new CompositeDiscount([
            new FixedDiscount(5000),
            new PercentageDiscount(5),
        ]);

        $compositeDiscount->apply($money);
    }

}
