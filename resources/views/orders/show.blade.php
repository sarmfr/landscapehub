@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <a href="{{ route('orders.index') }}" class="text-green-700 hover:underline">← My Orders</a>
            <h1 class="text-3xl font-bold mt-2">Order #{{ $order->order_number }}</h1>
            <p class="text-gray-600">Placed on {{ $order->created_at->format('M d, Y') }}</p>
        </div>
        <div class="text-right">
            <span class="px-4 py-2 rounded-full text-sm font-bold uppercase 
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Items -->
            <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="p-6 border-b bg-gray-50">
                    <h2 class="font-bold">Order Items</h2>
                </div>
                <div class="divide-y">
                    @foreach($order->items as $item)
                    <div class="p-6 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} @ KES {{ number_format($item->price) }}</p>
                        </div>
                        <div class="text-right flex flex-col items-end gap-2">
                            <p class="font-bold text-gray-900">KES {{ number_format($item->subtotal) }}</p>
                            @if($order->payment_status === 'completed')
                            <a href="{{ route('reviews.product', $item->product_id) }}" class="text-xs font-black text-green-700 hover:text-green-900 uppercase tracking-widest border border-green-700 px-3 py-1 rounded-full transition">Review Product</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="p-6 bg-gray-50 border-t flex justify-between items-center">
                    <span class="font-bold text-gray-700 text-lg">Total Amount</span>
                    <span class="font-black text-green-800 text-2xl">KES {{ number_format($order->total_amount) }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Payment Info -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h2 class="font-bold mb-4">Payment Information</h2>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-bold uppercase text-{{ $order->payment_status === 'completed' ? 'green' : 'red' }}-700">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Method:</span>
                        <span class="font-medium">M-Pesa ({{ $order->mpesa_phone }})</span>
                    </div>
                </div>
            </div>

            <!-- Help -->
            <div class="bg-green-50 rounded-xl p-6 border border-green-100 italic text-sm text-green-800">
                If you have any questions about your order, please contact our support team at support@landscapehub.co.ke
            </div>
        </div>
    </div>
</div>
@endsection