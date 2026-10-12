<?php

namespace Oscar\PooPractice\Models;

use Oscar\PooPractice\Contracts\DiscountRule;
use UnexpectedValueException;

class Order
{
    public function __construct(
        private readonly float $grossAmount,
        private readonly DiscountRule $rule
    ) {}

    public function total(): float
    {
        $total = $this->rule
            ->calculate($this->grossAmount);

        if ($total <= $this->grossAmount && $total >= 0) {
            return $total;
        }

        throw new UnexpectedValueException(
            message: 'Discount result must be between 0 and the gross amount'
        );
    }
}