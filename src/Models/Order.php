<?php

namespace Oscar\PooPractice\Models;

use Oscar\PooPractice\Contracts\DiscountRule;

class Order
{
 public function __construct(
     private readonly float $grossAmount,
     private readonly DiscountRule $rule)
 {}

 public function total(): float {
     return $this->rule
         ->calculate($this->grossAmount);
 }
}
