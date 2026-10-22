<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\DiscountRule;
use Oscar\SubscriptionBilling\Discount\NoDiscount;

class NoDiscountContractTest extends DiscountRuleContractTestCase
{
    protected function rule(): DiscountRule
    {
        return new NoDiscount();
    }
}
