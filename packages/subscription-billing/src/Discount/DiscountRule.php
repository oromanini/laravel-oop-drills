<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Money\Money;

interface DiscountRule
{
    /**
     * Applies the discount to the given price and returns the discounted price.
     *
     * Every implementation must guarantee:
     *  - the result is in the same currency as the given price;
     *  - the result is never greater than the given price;
     *  - the result is never negative.
     *
     * An implementation that cannot apply its rule to the given price must
     * throw an InvalidArgumentException instead of returning a wrong value.
     *
     * @throws InvalidArgumentException
     */
    public function apply(Money $price): Money;
}
