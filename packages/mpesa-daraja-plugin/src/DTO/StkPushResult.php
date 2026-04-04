<?php

namespace LandscapeHub\Payments\MpesaDaraja\DTO;

class StkPushResult
{
    public function __construct(
        public readonly bool $accepted,
        public readonly ?string $merchantRequestId,
        public readonly ?string $checkoutRequestId,
        public readonly ?string $responseCode,
        public readonly ?string $responseDescription,
        public readonly ?string $customerMessage,
        public readonly array $raw
    ) {
    }

    public function toArray(): array
    {
        return [
            'accepted' => $this->accepted,
            'merchant_request_id' => $this->merchantRequestId,
            'checkout_request_id' => $this->checkoutRequestId,
            'response_code' => $this->responseCode,
            'response_description' => $this->responseDescription,
            'customer_message' => $this->customerMessage,
            'raw' => $this->raw,
        ];
    }
}
