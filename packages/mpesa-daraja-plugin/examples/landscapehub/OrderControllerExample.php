<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderControllerExample extends Controller
{
    public function __construct(private readonly PaymentService $paymentService)
    {
        $this->middleware('auth');
    }

    public function payment(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        return view('orders.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'mpesa_phone' => ['required', 'string'],
        ]);

        $order->update([
            'mpesa_phone' => $request->string('mpesa_phone')->value(),
        ]);

        $payment = $this->paymentService->initiate($order);

        if ($payment['status'] !== 'pending_confirmation') {
            return back()->with('error', 'Unable to send the M-Pesa prompt. Please try again.');
        }

        $order->update([
            'merchant_request_id' => $payment['merchant_request_id'],
            'checkout_request_id' => $payment['checkout_request_id'],
            'payment_payload' => json_encode($payment['raw']),
            'payment_status' => 'pending',
        ]);

        return back()->with('success', $payment['customer_message'] ?? 'STK push sent. Complete payment on your phone.');
    }

    public function paymentStatus(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        return response()->json([
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'mpesa_reference' => $order->mpesa_reference,
        ]);
    }
}
