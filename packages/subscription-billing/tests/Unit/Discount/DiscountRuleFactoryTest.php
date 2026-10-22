<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\CompositeDiscount;
use Oscar\SubscriptionBilling\Discount\DiscountRuleFactory;
use Oscar\SubscriptionBilling\Discount\FixedDiscount;
use Oscar\SubscriptionBilling\Discount\NoDiscount;
use Oscar\SubscriptionBilling\Discount\PercentageDiscount;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(DiscountRuleFactory::class)]
class DiscountRuleFactoryTest extends TestCase
{
    #[Test]
    #[DataProvider('discountScenariosForFactory')]
    public function makeDiscounts(
        ?int $percent,
        ?int $fixedDiscountCents,
        string $instance,
        int $expected
    ): void {
        $money = Money::fromCents(10000, Currency::EUR);
        $discount = (new DiscountRuleFactory())
            ->make($percent, $fixedDiscountCents);

        $this->assertInstanceOf($instance, $discount);
        $this->assertSame($expected, ($discount->apply($money))->cents());
    }

    public static function discountScenariosForFactory(): array
    {
        return [
            'No Discount' => [
                'percent' => null,
                'fixedDiscountCents' => null,
                'instance' => NoDiscount::class,
                'expected' => 10000
            ],
            'Fixed Discount' => [
                'percent' => null,
                'fixedDiscountCents' => 1000,
                'instance' => FixedDiscount::class,
                'expected' => 9000
            ],
            'Percent Discount' => [
                'percent' => 10,
                'fixedDiscountCents' => null,
                'instance' => PercentageDiscount::class,
                'expected' => 9000
            ],
            'Composite Discount' => [
                'percent' => 10,
                'fixedDiscountCents' => 1000,
                'instance' => CompositeDiscount::class,
                'expected' => 8000
            ],
        ];
    }
}
