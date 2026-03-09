@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(count($items) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                @foreach($items as $item)
                <div class="p-6 border-b flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $item['product']->name }}</h3>
                        <p class="text-gray-600 text-sm">Quantity: {{ $item['quantity'] }}</p>
                        <p class="text-green-700 font-bold mt-2">KES {{ number_format($item['subtotal']) }}</p>
                    </div>
                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                        <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            <div class="space-y-3 mb-6 border-b pb-4">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>KES {{ number_format($total) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
            </div>
            <div class="flex justify-between font-bold text-lg mb-6">
                <span>Total:</span>
                <span class="text-green-700">KES {{ number_format($total) }}</span>
            </div>

            @auth
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Mpesa Phone Number</label>
                    <input type="tel" name="mpesa_phone" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                        placeholder="+254 7XX XXX XXX">
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                    Proceed to Payment
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block w-full text-center bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                Login to Checkout
            </a>
            @endauth
        </div>
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-600 text-lg mb-6">Your cart is empty</p>
        <a href="{{ route('products') }}" class="inline-block bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800">
            Continue Shopping
        </a>
    </div>
    @endif
</div>
@endsection