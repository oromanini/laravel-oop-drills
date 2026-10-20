<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Money\Money;

final class FixedDiscount implements DiscountRule
{
    private const int MAX_PERCENT = 30;

    public function __construct(private readonly int $discountCents)
    {
    }

    public function apply(Money $price): Money
    {
        ($this->discountCents * 100 > $price->cents() * self::MAX_PERCENT)
        && throw new InvalidArgumentException('Fixed discount must not exceed 30% of the price.');

        $fixedDiscount = Money::fromCents($this->discountCents, $price->currency());

        return $price->subtract($fixedDiscount);
    }
}
