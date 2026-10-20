<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Feature;

use Oscar\SubscriptionBilling\SubscriptionBillingServiceProvider;
use Oscar\SubscriptionBilling\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;

#[CoversClass(SubscriptionBillingServiceProvider::class)]
class SubscriptionBillingServiceProviderTest extends TestCase
{
    #[Test]
    public function theProviderIsLoadedByTheApplication(): void {
        $this->assertTrue(
            $this->app->providerIsLoaded(SubscriptionBillingServiceProvider::class)
        );
    }
}