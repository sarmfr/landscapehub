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
                    <p class="text-gray-600 text-sm italic">Paying via Lipa na M-Pesa</p>
                    <p class="font-bold text-green-700">{{ $order->mpesa_phone }}</p>
                </div>
            </div>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-lg">
                <div class="flex items-start">
                    <div class="text-blue-500 mr-4">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 mb-1">Payment Instructions</h3>
                        <ol class="list-decimal list-inside text-blue-800 space-y-1 text-sm">
                            <li>You will receive an M-Pesa STK push on your phone</li>
                            <li>Enter your M-Pesa PIN to authorize the payment</li>
                            <li>Once authorized, click the button below to confirm</li>
                        </ol>
                    </div>
                </div>
            </div>

            <form action="{{ route('order.payment.process', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1 flex items-center justify-center">
                    <span>Confirm I Have Paid</span>
                </button>
            </form>

            <p class="text-center text-gray-500 text-sm mt-6">
                Having issues? <a href="#" class="text-green-700 font-bold hover:underline">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection