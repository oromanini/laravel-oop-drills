<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Money\Money;

final class PercentageDiscount implements DiscountRule
{
    public function __construct(private readonly int $percent)
    {
        ($percent < 0 || $percent > 100)
        && throw new InvalidArgumentException('Discount percent must be between 0 and 100.');
    }

    public function apply(Money $price): Money
    {
        return $price->subtract($price->percentage($this->percent));
    }
}
