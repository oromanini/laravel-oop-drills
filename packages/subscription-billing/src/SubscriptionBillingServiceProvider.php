<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling;

use Illuminate\Support\ServiceProvider;

class SubscriptionBillingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bindings for the payment gateway contract and discount rules go here.
    }

    public function boot(): void
    {
        // Runs after all providers are registered, so the container is fully available
    }
}
