<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\DiscountRule;

class NoDiscount implements DiscountRule {

    public function calculate(float $amount): float
    {
        return $amount;
    }
}
