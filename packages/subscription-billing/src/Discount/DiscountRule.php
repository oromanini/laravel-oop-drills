<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use Oscar\SubscriptionBilling\Money\Money;

interface DiscountRule
{
    public function apply(Money $price): Money;
}
