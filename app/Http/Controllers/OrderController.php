<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(\App\Services\PaymentService $paymentService)
    {
        $this->middleware('auth')->except(['handlePaymentCallback', 'handlePaymentWebhook']);
        $this->paymentService = $paymentService;
    }

    public function payment(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'mpesa_phone' => ['required', 'string', 'max:20'],
        ]);

        $order->update([
            'mpesa_phone' => $request->input('mpesa_phone'),
        ]);

        $paymentResult = $this->paymentService->initiate($order);

        if ($paymentResult['status'] === 'already_paid') {
            return redirect()->route('orders.show', $order->id)->with('success', $paymentResult['message']);
        }

        if ($paymentResult['status'] === 'pending_confirmation') {
            $message = $paymentResult['customer_message'] ?? 'M-Pesa prompt sent. Complete the payment on your phone.';

            return redirect()
                ->route('order.payment', $order->id)
                ->with('success', $message);
        }

        if ($paymentResult['status'] === 'completed') {
            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', $paymentResult['message'] ?? 'Payment completed successfully.');
        }

        return back()->with('error', $paymentResult['message'] ?? 'Payment processing failed. Please try again.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function myOrders()
    {
        try {
            $orders = Auth::user()->orders()->latest()->paginate(10);
        } catch (QueryException|PDOException $e) {
            report($e);

            return redirect()
                ->route('home')
                ->with('error', 'Orders are temporarily unavailable. Please try again shortly.');
        }

        return view('orders.index', compact('orders'));
    }

    public function paymentStatus(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'mpesa_reference' => $order->mpesa_reference,
            'checkout_request_id' => $order->checkout_request_id,
        ]);
    }

    /**
     * API Ready: Handle payment callbacks for plugins.
     */
    public function handlePaymentCallback(Request $request)
    {
        $this->paymentService->handleWebhook($request);

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }

    /**
     * API Ready: Handle automated webhooks for plugins.
     */
    public function handlePaymentWebhook(Request $request)
    {
        $this->paymentService->handleWebhook($request);

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Accepted',
        ]);
    }
}
