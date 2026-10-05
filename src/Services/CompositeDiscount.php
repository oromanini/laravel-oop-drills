<?php

namespace Oscar\PooPractice\Services;

use Oscar\PooPractice\Contracts\DiscountRule;

final class CompositeDiscount implements DiscountRule
{
    public function __construct(private readonly array $rules)
    {}

    public function calculate(float $amount): float
    {
        foreach ($this->rules as $rule) {
            $amount = $rule->calculate($amount);
        }

        return $amount;
    }
}
