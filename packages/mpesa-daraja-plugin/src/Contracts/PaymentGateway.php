<?php

namespace LandscapeHub\Payments\MpesaDaraja\Contracts;

use LandscapeHub\Payments\MpesaDaraja\DTO\CallbackResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\QueryResult;
use LandscapeHub\Payments\MpesaDaraja\DTO\StkPushResult;

interface PaymentGateway
{
    public function initiateStkPush(
        string $phoneNumber,
        int|float|string $amount,
        string $reference,
        string $description,
        ?string $callbackUrl = null
    ): StkPushResult;

    public function queryStkPush(string $checkoutRequestId): QueryResult;

    public function parseStkCallback(array $payload): CallbackResult;
}
