<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

use Oscar\SubscriptionBilling\Money\Money;

final class CompositeDiscount implements DiscountRule
{
    public function __construct(private readonly array $rules)
    {
    }

    public function apply(Money $price): Money
    {
        foreach ($this->rules as $rule) {
            $price = $rule->apply($price);
        }

        return $price;
    }
}
