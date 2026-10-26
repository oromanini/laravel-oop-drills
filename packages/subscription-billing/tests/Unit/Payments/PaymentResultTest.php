<?php

declare(strict_types=1);

namespace Oscar\SubscriptionBilling\Tests\Unit\Payments;

use InvalidArgumentException;
use Oscar\SubscriptionBilling\Payments\PaymentResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentResult::class)]
class PaymentResultTest extends TestCase
{
    #[Test]
    public function exposesTheTransactionIdOfASuccessfulPayment(): void
    {
        $result = PaymentResult::succeeded('txn_123');
        $this->assertTrue($result->isSuccessful());
        $this->assertSame(expected: 'txn_123', actual: $result->transactionId());
    }

    #[Test]
    public function exposesTheReasonOfADeclinedPayment(): void
    {
        $result = PaymentResult::declined('Card expired.');
        $this->assertFalse($result->isSuccessful());
        $this->assertSame(expected: 'Card expired.', actual: $result->failureReason());
        $this->assertNull($result->transactionId());
    }

    #[Test]
    #[DataProvider('blankTransactionIds')]
    public function refusesASuccessfulPaymentWithoutTransactionId(string $transactionId): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Transaction ID must not be empty.');
        PaymentResult::succeeded($transactionId);
    }

    public static function blankTransactionIds(): array
    {
        return [
            'empty' => ['transactionId' => ''],
            'only space' => ['transactionId' => ' ']
        ];
    }

    #[Test]
    #[DataProvider('blankFailureReasons')]
    public function refusesADeclinedPaymentWithoutReason(string $failureReason): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Failure reason must not be empty.');
        PaymentResult::declined($failureReason);
    }

    public static function blankFailureReasons(): array
    {
        return [
            'empty' => ['failureReason' => ''],
            'only spaces' => ['failureReason' => ' ']
        ];
    }
}
