<?php

namespace LandscapeHub\Payments\MpesaDaraja\Services;

use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use LandscapeHub\Payments\MpesaDaraja\DTO\CallbackResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\QueryResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\StkPushResult;

class DarajaGateway implements PaymentGateway
{
    public function __construct(private readonly DarajaClient $client)
    {
    }

    public function initiateStkPush(
        string $phoneNumber,
        int|float|string $amount,
        string $reference,
        string $description,
        ?string $callbackUrl = null
    ): StkPushResult {
        return $this->client->initiateStkPush($phoneNumber, $amount, $reference, $description, $callbackUrl);
    }

    public function queryStkPush(string $checkoutRequestId): QueryResult
    {
        return $this->client->queryStkPush($checkoutRequestId);
    }

    public function parseStkCallback(array $payload): CallbackResult
    {
        return $this->client->parseStkCallback($payload);
    }
}
