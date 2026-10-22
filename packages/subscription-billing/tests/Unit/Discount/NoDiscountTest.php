<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\NoDiscount;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(NoDiscount::class)]
class NoDiscountTest extends TestCase
{
    #[Test]
    public function noDiscountNotChangeFinalPrice(): void
    {
        $money = Money::fromCents(10000, Currency::EUR);
        $discount = new NoDiscount();
        $this->assertSame(
            expected: 10000,
            actual: $discount->apply($money)->cents()
        );
    }
}
