@extends('layouts.app')

@section('title', 'Order Payment')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-green-800 text-white p-8 text-center">
            <h1 class="text-3xl font-bold mb-2">Complete Your Payment</h1>
            <p class="text-green-100">Order #{{ $order->order_number }}</p>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-center mb-8 pb-6 border-b">
                <div>
                    <p class="text-gray-600 text-sm uppercase font-bold tracking-wider">Amount to Pay</p>
                    <p class="text-4xl font-black text-gray-900">KES {{ number_format($order->total_amount) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600 text-sm italic">Lipa na M-Pesa</p>
                    <p class="font-bold text-green-700">{{ $order->mpesa_phone ?: 'Add a payment phone number below' }}</p>
                </div>
            </div>

            @if ($order->payment_status === 'completed')
                <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-6">
                    <h2 class="font-bold text-lg mb-2">Payment received</h2>
                    <p>Your payment was confirmed successfully.</p>
                    @if ($order->mpesa_reference)
                        <p class="mt-2 text-sm">Receipt: <span class="font-semibold">{{ $order->mpesa_reference }}</span></p>
                    @endif
                    <a href="{{ route('orders.show', $order->id) }}" class="inline-flex mt-4 bg-green-700 text-white px-5 py-3 rounded-lg font-semibold hover:bg-green-800">
                        View Order
                    </a>
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-lg">
                    <h3 class="font-bold text-blue-900 mb-2">Payment Instructions</h3>
                    <ol class="list-decimal list-inside text-blue-800 space-y-1 text-sm">
                        <li>Enter the Safaricom number that should receive the STK prompt.</li>
                        <li>Tap "Send M-Pesa Prompt".</li>
                        <li>Approve the payment on your phone with your M-Pesa PIN.</li>
                        <li>Keep this page open while we wait for Safaricom to confirm the payment.</li>
                    </ol>
                </div>

                <form action="{{ route('order.payment.process', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="mpesa_phone" class="block text-sm font-semibold mb-2">M-Pesa Phone Number</label>
                        <input
                            id="mpesa_phone"
                            type="tel"
                            name="mpesa_phone"
                            value="{{ old('mpesa_phone', $order->mpesa_phone) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-green-600"
                            placeholder="0712345678 or 254712345678"
                        >
                        @error('mpesa_phone')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg">
                        {{ $order->checkout_request_id ? 'Send M-Pesa Prompt Again' : 'Send M-Pesa Prompt' }}
                    </button>
                </form>

                @if (session('success') || $order->checkout_request_id)
                    <div
                        class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-5 py-4 text-amber-900"
                        data-payment-monitor
                        data-status-url="{{ route('order.payment.status', $order->id) }}"
                        data-order-url="{{ route('orders.show', $order->id) }}"
                    >
                        <p class="font-semibold">Waiting for M-Pesa confirmation</p>
                        <p class="text-sm mt-1">Complete the prompt on your phone. This page checks your payment status automatically.</p>
                    </div>
                @endif

                <p class="text-center text-gray-500 text-sm mt-6">
                    Having issues? <a href="mailto:admin@landscapehub.com?subject=Payment%20Support" class="text-green-700 font-bold hover:underline">Contact Support</a>
                </p>
            @endif
        </div>
    </div>
</div>

@if ($order->payment_status !== 'completed')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const monitor = document.querySelector('[data-payment-monitor]');

    if (!monitor) {
        return;
    }

    const statusUrl = monitor.dataset.statusUrl;
    const orderUrl = monitor.dataset.orderUrl;

    const poll = async function () {
        try {
            const response = await fetch(statusUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                return;
            }

            const data = await response.json();

            if (data.payment_status === 'completed') {
                window.location.href = orderUrl;
                return;
            }

            if (data.payment_status === 'failed') {
                monitor.className = 'mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-900';
                monitor.innerHTML = '<p class="font-semibold">Payment was not completed</p><p class="text-sm mt-1">You can send the M-Pesa prompt again.</p>';
            }
        } catch (error) {
            console.error('Unable to check payment status.', error);
        }
    };

    poll();
    window.setInterval(poll, 5000);
});
</script>
@endif
@endsection
