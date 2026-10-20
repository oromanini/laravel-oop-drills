<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\DiscountRule;
use Oscar\SubscriptionBilling\Discount\PercentageDiscount;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PercentageDiscount::class)]
final class PercentageDiscountContractTest extends DiscountRuleContractTestCase
{
    protected function rule(): DiscountRule
    {
        return new PercentageDiscount(10);
    }
}
