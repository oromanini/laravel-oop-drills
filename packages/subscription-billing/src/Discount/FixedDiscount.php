<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Money\Money;

final class FixedDiscount implements DiscountRule
{
    public const int MAX_LIMIT = 30;

    public function __construct(private readonly int $discount)
    {
    }

    public function apply(Money $price): Money
    {

        ($this->discount * 100 > $price->cents() * self::MAX_LIMIT)
        && throw new InvalidArgumentException('Fixed discount must not exceed 30% of the price.');

        $fixedDiscount = Money::fromCents($this->discount, $price->currency());

        return $price->subtract($fixedDiscount);
    }
}
