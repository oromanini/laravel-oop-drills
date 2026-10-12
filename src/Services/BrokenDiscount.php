<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\DiscountRule;

class BrokenDiscount implements DiscountRule
{

    public function calculate(float $amount): float
    {
        return $amount * 1.1; //should be * -1
    }
}