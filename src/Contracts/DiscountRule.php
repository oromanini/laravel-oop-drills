<?php

namespace Oscar\PooPractice\Contracts;

interface DiscountRule
{
    public function calculate(float $amount): float;
}
