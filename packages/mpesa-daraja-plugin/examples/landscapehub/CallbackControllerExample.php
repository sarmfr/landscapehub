<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CallbackControllerExample extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->paymentService->handleWebhook($request);

        $order = Order::query()
            ->where('checkout_request_id', $result['checkout_request_id'] ?? null)
            ->first();

        if ($order && $result['successful']) {
            $order->update([
                'payment_status' => 'completed',
                'status' => 'processing',
                'mpesa_reference' => $result['receipt_number'],
            ]);
        }

        if ($order && !$result['successful']) {
            $order->update([
                'payment_status' => 'failed',
            ]);
        }

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}
