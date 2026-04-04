<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Payments\MockPaymentGateway;
use PHPUnit\Framework\TestCase;

class MockPaymentGatewayTest extends TestCase
{
    public function test_it_returns_an_accepted_mock_payment_response(): void
    {
        $gateway = new MockPaymentGateway();

        $result = $gateway->initiateStkPush(
            phoneNumber: '254700000000',
            amount: 1500,
            reference: 'ORD-TEST-0001',
            description: 'Test payment'
        );

        $this->assertTrue($result->accepted);
        $this->assertNotNull($result->merchantRequestId);
        $this->assertNotNull($result->checkoutRequestId);
        $this->assertSame('0', $result->responseCode);
    }
}
