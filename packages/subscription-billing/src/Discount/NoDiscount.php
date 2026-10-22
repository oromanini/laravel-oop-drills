<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use Oscar\SubscriptionBilling\Money\Money;

final class NoDiscount implements DiscountRule
{
    public function apply(Money $price): Money
    {
        return $price;
    }
}
