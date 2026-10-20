<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\DiscountRule;
use Oscar\SubscriptionBilling\Discount\FixedDiscount;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FixedDiscount::class)]
final class FixedDiscountContractTest extends DiscountRuleContractTestCase
{
    protected function rule(): DiscountRule
    {
        return new FixedDiscount(3000);
    }
}
