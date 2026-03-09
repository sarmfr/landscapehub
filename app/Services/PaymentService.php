<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * PaymentService - Gateway for external payment plugin integration.
 *
 * This service is designed to be "API ready" for M-Pesa, Stripe, or other providers.
 * To integrate a specific provider, update the methods below or inject a provider-specific plugin.
 */
class PaymentService
{
    /**
     * Initiate a payment request.
     * Use this to get a redirect URL or a payment session ID.
     */
    public function initiate(Order $order): array
    {
        Log::info('Payment initiated for Order: ' . $order->order_number);

        // Placeholder for future API integration logic
        // Example: $response = Http::post('https://api.payment-provider.com/checkout', [...]);

        return [
            'status' => 'initiated',
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            // 'redirect_url' => $response->json('url'),
        ];
    }

    /**
     * Verify a payment status using a reference.
     */
    public function verify(string $reference): bool
    {
        Log::info('Verifying payment for reference: ' . $reference);

        // Placeholder for verification logic
        return true;
    }

    /**
     * Handle asynchronous webhooks/callbacks.
     */
    public function handleWebhook(Request $request): array
    {
        $payload = $request->all();
        Log::info('Payment Webhook Received', $payload);

        // Map provider status to local status
        // Update Order status based on payload

        return ['status' => 'processed'];
    }
}
