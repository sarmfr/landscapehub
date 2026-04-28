<?php

namespace App\Services;

use App\Mail\OrderNotification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use LandscapeHub\Payments\MpesaDaraja\Contracts\PaymentGateway;
use Throwable;

class PaymentService
{
    public function __construct(
        private readonly PaymentGateway $gateway,
        private readonly SafeMailService $safeMail
    ) {
    }

    /**
     * Initiate a payment request.
     */
    public function initiate(Order $order): array
    {
        if ($order->payment_status === 'completed') {
            return [
                'status' => 'already_paid',
                'message' => 'This order has already been paid for.',
            ];
        }

        try {
            Log::info('Daraja payment initiated.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'provider' => config('payment.default', 'mpesa'),
            ]);

            $response = $this->gateway->initiateStkPush(
                phoneNumber: (string) $order->mpesa_phone,
                amount: $order->total_amount,
                reference: $order->order_number,
                description: 'Landscape order',
                callbackUrl: $this->callbackUrl()
            );

            $order->update([
                'payment_provider' => config('payment.default', 'mpesa'),
                'merchant_request_id' => $response->merchantRequestId,
                'checkout_request_id' => $response->checkoutRequestId,
                'payment_payload' => [
                    'initiate' => $response->toArray(),
                ],
            ]);

            if (config('payment.default') === 'mock' && $response->accepted) {
                $receiptNumber = 'MOCK-' . strtoupper(Str::random(10));

                $this->markOrderAsPaid(
                    $order,
                    receiptNumber: $receiptNumber,
                    phoneNumber: (string) $order->mpesa_phone,
                    payload: [
                        'mock_payment' => [
                            'receipt_number' => $receiptNumber,
                            'completed_at' => now()->toIso8601String(),
                        ],
                    ]
                );

                return [
                    'status' => 'completed',
                    'merchant_request_id' => $response->merchantRequestId,
                    'checkout_request_id' => $response->checkoutRequestId,
                    'customer_message' => 'Mock payment completed successfully.',
                    'message' => 'Mock payment completed successfully.',
                    'raw' => $response->toArray(),
                ];
            }

            return [
                'status' => $response->accepted ? 'pending_confirmation' : 'failed',
                'merchant_request_id' => $response->merchantRequestId,
                'checkout_request_id' => $response->checkoutRequestId,
                'customer_message' => $response->customerMessage,
                'message' => $response->responseDescription,
                'raw' => $response->toArray(),
            ];
        } catch (Throwable $e) {
            Log::error('Daraja payment initiation failed.', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => 'failed',
                'message' => 'Unable to start the M-Pesa payment right now.',
            ];
        }
    }

    /**
     * Verify a payment status using a checkout request ID.
     */
    public function verify(string $reference): bool
    {
        try {
            Log::info('Verifying M-Pesa payment.', ['checkout_request_id' => $reference]);

            return $this->gateway->queryStkPush($reference)->successful;
        } catch (Throwable $e) {
            Log::warning('M-Pesa payment verification failed.', [
                'checkout_request_id' => $reference,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Handle asynchronous webhooks/callbacks.
     */
    public function handleWebhook(Request $request): array
    {
        $payload = $request->all();
        Log::info('Payment webhook received.', $payload);

        try {
            $callback = $this->gateway->parseStkCallback($payload);
        } catch (Throwable $e) {
            Log::error('Unable to parse M-Pesa callback.', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return [
                'status' => 'invalid',
                'successful' => false,
            ];
        }

        $order = Order::query()
            ->where('checkout_request_id', $callback->checkoutRequestId)
            ->orWhere('merchant_request_id', $callback->merchantRequestId)
            ->first();

        if (!$order) {
            Log::warning('M-Pesa callback received for an unknown order.', [
                'checkout_request_id' => $callback->checkoutRequestId,
                'merchant_request_id' => $callback->merchantRequestId,
            ]);

            return [
                'status' => 'not_found',
                'successful' => false,
                'checkout_request_id' => $callback->checkoutRequestId,
            ];
        }

        $existingPayload = $order->payment_payload ?? [];
        $mergedPayload = array_merge($existingPayload, [
            'callback' => $callback->toArray(),
        ]);

        if ($callback->successful) {
            $this->markOrderAsPaid(
                $order,
                receiptNumber: $callback->receiptNumber,
                phoneNumber: $callback->phoneNumber,
                payload: [
                    'callback' => $callback->toArray(),
                ]
            );

            return [
                'status' => 'processed',
                'successful' => true,
                'order_id' => $order->id,
                'checkout_request_id' => $callback->checkoutRequestId,
                'receipt_number' => $callback->receiptNumber,
            ];
        }

        if ($order->payment_status !== 'completed') {
            $order->update([
                'payment_status' => 'failed',
                'payment_provider' => config('payment.default', 'mpesa'),
                'payment_payload' => $mergedPayload,
                'notes' => trim(($order->notes ? $order->notes . PHP_EOL : '') . ($callback->resultDescription ?? 'Payment failed')),
            ]);
        }

        return [
            'status' => 'processed',
            'successful' => false,
            'order_id' => $order->id,
            'checkout_request_id' => $callback->checkoutRequestId,
            'result_code' => $callback->resultCode,
            'result_description' => $callback->resultDescription,
        ];
    }

    protected function sendOrderNotifications(Order $order): void
    {
        if ($order->user?->email) {
            $this->safeMail->queue(
                $order->user->email,
                new OrderNotification($order, 'customer'),
                'Customer order email failed to queue.',
                [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                ]
            );
        }

        $vendors = $order->items
            ->map(fn ($item) => $item->product?->vendor)
            ->filter()
            ->unique('id');

        foreach ($vendors as $vendor) {
            if (!$vendor->user?->email) {
                continue;
            }

            $this->safeMail->queue(
                $vendor->user->email,
                new OrderNotification($order, 'vendor'),
                'Vendor order email failed to queue.',
                [
                    'order_id' => $order->id,
                    'vendor_id' => $vendor->id,
                ]
            );
        }
    }

    protected function callbackUrl(): string
    {
        return (string) (config('mpesa-daraja.callback_url') ?: route('payments.webhook'));
    }

    protected function markOrderAsPaid(
        Order $order,
        ?string $receiptNumber = null,
        ?string $phoneNumber = null,
        array $payload = []
    ): void {
        $wasAlreadyCompleted = $order->payment_status === 'completed';
        $mergedPayload = array_merge($order->payment_payload ?? [], $payload);

        $order->update([
            'payment_status' => 'completed',
            'status' => $order->status === 'completed' ? 'completed' : 'processing',
            'payment_provider' => config('payment.default', 'mpesa'),
            'mpesa_reference' => $receiptNumber ?: $order->mpesa_reference,
            'mpesa_phone' => $phoneNumber ?: $order->mpesa_phone,
            'payment_payload' => $mergedPayload,
        ]);

        if (!$wasAlreadyCompleted) {
            $this->sendOrderNotifications($order->fresh(['user', 'items.product.vendor.user']));
        }
    }
}
