<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Money;

enum Currency: string
{
    case EUR = 'EUR';
    case USD = 'USD';
    case BRL = 'BRL';
}
