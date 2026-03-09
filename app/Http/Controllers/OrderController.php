<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotification;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(\App\Services\PaymentService $paymentService)
    {
        $this->middleware('auth');
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

        // Use the PaymentService to initiate/process the payment
        $paymentResult = $this->paymentService->initiate($order);

        // Simulating successful response for now
        if ($paymentResult['status'] === 'initiated') {
            $order->update([
                'payment_status' => 'completed', // In real API, wait for webhook/verification
                'status' => 'processing',
                'mpesa_reference' => $request->input('mpesa_reference'), // Placeholder
            ]);

            // Notify Customer
            Mail::to($order->user->email)->queue(new OrderNotification($order, 'customer'));

            // Notify Vendors involved in this order
            $vendors = $order->items->map(function ($item) {
                return $item->product ? $item->product->vendor : null;
            })->filter()->unique('id');

            foreach ($vendors as $vendor) {
                Mail::to($vendor->user->email)->queue(new OrderNotification($order, 'vendor'));
            }

            return redirect()->route('orders.show', $order->id)->with('success', 'Payment successful! Your order is being processed.');
        }

        return back()->with('error', 'Payment processing failed. Please try again.');
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
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * API Ready: Handle payment callbacks for plugins.
     */
    public function handlePaymentCallback(Request $request)
    {
        $result = $this->paymentService->handleWebhook($request);
        return response()->json($result);
    }

    /**
     * API Ready: Handle automated webhooks for plugins.
     */
    public function handlePaymentWebhook(Request $request)
    {
        $result = $this->paymentService->handleWebhook($request);
        return response()->json($result);
    }
}
