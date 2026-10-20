<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\DiscountRule;
use Oscar\SubscriptionBilling\Money\Currency;
use Oscar\SubscriptionBilling\Money\Money;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

abstract class DiscountRuleContractTestCase extends TestCase
{
    abstract protected function rule(): DiscountRule;

    #[Test]
    public function keepsTheCurrencyOfThePrice(): void
    {
        $price = Money::fromCents(10000, Currency::EUR);
        $result = $this->rule()->apply($price);

        $this->assertSame(expected: Currency::EUR, actual: $result->currency());
    }

    #[Test]
    public function neverReturnsMoreThanThePrice(): void
    {
        $price = Money::fromCents(10000, Currency::EUR);
        $result = $this->rule()->apply($price);
        $this->assertLessThanOrEqual(10000, actual: $result->cents());
    }
}
