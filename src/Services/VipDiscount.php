<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\DiscountRule;

class VipDiscount implements DiscountRule
{

    public function calculate(float $amount): float
    {
        return $amount * 0.85;
    }
}
