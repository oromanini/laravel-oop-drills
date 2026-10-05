<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\DiscountRule;
use Oscar\PooPractice\Factories\DiscountRuleFactory;
use Oscar\PooPractice\Models\Order;

class OrderService
{
    public function __construct(private readonly DiscountRuleFactory $discountRuleFactory)
    {}

    public function calculateTotal(float $amount, bool $isVip, bool $hasCoupon): float
    {
        $rule = $this->discountRuleFactory->make($isVip, $hasCoupon);

        return (new Order(grossAmount: $amount, rule: $rule))
            ->total();
    }
}
