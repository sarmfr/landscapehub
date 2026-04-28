<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;

class PaymentServiceExample
{
    public function __construct(private readonly PaymentGateway $gateway)
    {
    }

    public function initiate(Order $order): array
    {
        $response = $this->gateway->initiateStkPush(
            phoneNumber: $order->mpesa_phone,
            amount: $order->total_amount,
            reference: $order->order_number,
            description: 'Landscape order',
            callbackUrl: route('payments.callback')
        );

        return [
            'status' => $response->accepted ? 'pending_confirmation' : 'failed',
            'merchant_request_id' => $response->merchantRequestId,
            'checkout_request_id' => $response->checkoutRequestId,
            'customer_message' => $response->customerMessage,
            'raw' => $response->toArray(),
        ];
    }

    public function verify(string $checkoutRequestId): bool
    {
        return $this->gateway->queryStkPush($checkoutRequestId)->successful;
    }

    public function handleWebhook(Request $request): array
    {
        $callback = $this->gateway->parseStkCallback($request->all());

        return [
            'successful' => $callback->successful,
            'checkout_request_id' => $callback->checkoutRequestId,
            'receipt_number' => $callback->receiptNumber,
            'phone_number' => $callback->phoneNumber,
            'amount' => $callback->amount,
            'result_code' => $callback->resultCode,
            'result_description' => $callback->resultDescription,
        ];
    }
}
