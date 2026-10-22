<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Discount;

use Oscar\SubscriptionBilling\Discount\CompositeDiscount;
use Oscar\SubscriptionBilling\Discount\DiscountRule;
use Oscar\SubscriptionBilling\Discount\FixedDiscount;
use Oscar\SubscriptionBilling\Discount\PercentageDiscount;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CompositeDiscount::class)]
final class CompositeDiscountContractTest extends DiscountRuleContractTestCase
{
    protected function rule(): DiscountRule
    {
        return new CompositeDiscount([
            new PercentageDiscount(10),
            new FixedDiscount(1000)
        ]);
    }
}
