<?php

namespace LandscapeHub\Payments\MpesaDaraja\DTO;

class QueryResult
{
    public function __construct(
        public readonly bool $successful,
        public readonly ?string $responseCode,
        public readonly ?string $responseDescription,
        public readonly ?string $merchantRequestId,
        public readonly ?string $checkoutRequestId,
        public readonly ?string $resultCode,
        public readonly ?string $resultDescription,
        public readonly array $raw
    ) {
    }

    public function toArray(): array
    {
        return [
            'successful' => $this->successful,
            'response_code' => $this->responseCode,
            'response_description' => $this->responseDescription,
            'merchant_request_id' => $this->merchantRequestId,
            'checkout_request_id' => $this->checkoutRequestId,
            'result_code' => $this->resultCode,
            'result_description' => $this->resultDescription,
            'raw' => $this->raw,
        ];
    }
}
