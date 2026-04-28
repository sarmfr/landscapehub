<?php

namespace LandscapeHub\Payments\MpesaDaraja\DTO;

class CallbackResult
{
    public function __construct(
        public readonly bool $successful,
        public readonly ?string $merchantRequestId,
        public readonly ?string $checkoutRequestId,
        public readonly ?int $resultCode,
        public readonly ?string $resultDescription,
        public readonly ?string $receiptNumber,
        public readonly ?float $amount,
        public readonly ?string $phoneNumber,
        public readonly ?string $transactionDate,
        public readonly array $metadata,
        public readonly array $raw
    ) {
    }

    public function toArray(): array
    {
        return [
            'successful' => $this->successful,
            'merchant_request_id' => $this->merchantRequestId,
            'checkout_request_id' => $this->checkoutRequestId,
            'result_code' => $this->resultCode,
            'result_description' => $this->resultDescription,
            'receipt_number' => $this->receiptNumber,
            'amount' => $this->amount,
            'phone_number' => $this->phoneNumber,
            'transaction_date' => $this->transactionDate,
            'metadata' => $this->metadata,
            'raw' => $this->raw,
        ];
    }
}
