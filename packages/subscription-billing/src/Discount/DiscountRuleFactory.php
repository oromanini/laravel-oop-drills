<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Discount;

final class DiscountRuleFactory
{
    public function make(?int $percent, ?int $fixedDiscountCents): DiscountRule
    {
        return match (true) {
            !is_null($fixedDiscountCents) && !is_null($percent) => new CompositeDiscount([
                new PercentageDiscount($percent),
                new FixedDiscount($fixedDiscountCents),
            ]),
            !is_null($percent) => new PercentageDiscount($percent),
            !is_null($fixedDiscountCents) => new FixedDiscount($fixedDiscountCents),
            default => new NoDiscount(),
        };
    }
}
