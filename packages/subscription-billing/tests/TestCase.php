<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Oscar\SubscriptionBilling\SubscriptionBillingServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [SubscriptionBillingServiceProvider::class];
    }
}