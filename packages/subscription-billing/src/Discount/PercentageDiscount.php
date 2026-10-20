<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use Oscar\SubscriptionBilling\Money\Money;

final class PercentageDiscount implements DiscountRule
{
    public function __construct(private readonly int $percent)
    {}

    public function apply(Money $price): Money
    {
        return $price->subtract($price->percentage($this->percent));
    }
}