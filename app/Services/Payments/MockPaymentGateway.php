<?php

namespace App\Services\Payments;

use Illuminate\Support\Str;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use LandscapeHub\Payments\MpesaDaraja\DTO\CallbackResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\QueryResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\StkPushResult;

class MockPaymentGateway implements PaymentGateway
{
    public function initiateStkPush(
        string $phoneNumber,
        int|float|string $amount,
        string $reference,
        string $description,
        ?string $callbackUrl = null
    ): StkPushResult {
        $merchantRequestId = 'mock-merchant-' . Str::uuid()->toString();
        $checkoutRequestId = 'mock-checkout-' . Str::uuid()->toString();

        return new StkPushResult(
            accepted: true,
            merchantRequestId: $merchantRequestId,
            checkoutRequestId: $checkoutRequestId,
            responseCode: '0',
            responseDescription: 'Mock payment accepted.',
            customerMessage: 'Mock payment completed successfully.',
            raw: [
                'phone_number' => $phoneNumber,
                'amount' => (float) $amount,
                'reference' => $reference,
                'description' => $description,
                'callback_url' => $callbackUrl,
            ]
        );
    }

    public function queryStkPush(string $checkoutRequestId): QueryResult
    {
        return new QueryResult(
            successful: str_starts_with($checkoutRequestId, 'mock-checkout-'),
            responseCode: '0',
            responseDescription: 'Mock payment status available.',
            merchantRequestId: null,
            checkoutRequestId: $checkoutRequestId,
            resultCode: '0',
            resultDescription: 'The service request is processed successfully.',
            raw: [
                'checkout_request_id' => $checkoutRequestId,
            ]
        );
    }

    public function parseStkCallback(array $payload): CallbackResult
    {
        return new CallbackResult(
            successful: (bool) ($payload['successful'] ?? true),
            merchantRequestId: $payload['merchant_request_id'] ?? null,
            checkoutRequestId: $payload['checkout_request_id'] ?? null,
            resultCode: isset($payload['result_code']) ? (int) $payload['result_code'] : 0,
            resultDescription: $payload['result_description'] ?? 'Mock callback processed successfully.',
            receiptNumber: $payload['receipt_number'] ?? ('MOCK-' . strtoupper(Str::random(10))),
            amount: isset($payload['amount']) ? (float) $payload['amount'] : null,
            phoneNumber: $payload['phone_number'] ?? null,
            transactionDate: $payload['transaction_date'] ?? now()->format('YmdHis'),
            metadata: $payload['metadata'] ?? [],
            raw: $payload
        );
    }
}
