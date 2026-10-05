<?php

namespace Oscar\PooPractice\Factories;

use Oscar\PooPractice\Contracts\DiscountRule;
use Oscar\PooPractice\Services\CompositeDiscount;
use Oscar\PooPractice\Services\CouponDiscount;
use Oscar\PooPractice\Services\NoDiscount;
use Oscar\PooPractice\Services\VipDiscount;

class DiscountRuleFactory
{
    public function make(bool $isVip, bool $hasCoupon): DiscountRule
    {
        return match (true) {
            $isVip && $hasCoupon => new CompositeDiscount([
                new VipDiscount(),
                new CouponDiscount(),
            ]),
            $isVip => new VipDiscount(),
            $hasCoupon => new CouponDiscount(),
            default => new NoDiscount(),
        };
    }
}
