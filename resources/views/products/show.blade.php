@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <div class="mb-8 text-gray-600 text-sm">
        <a href="{{ route('home') }}" class="hover:text-green-700">Home</a> /
        <a href="{{ route('products') }}" class="hover:text-green-700">Products</a> /
        <span>{{ $product->name }}</span>
    </div>

    <!-- Product Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-white p-8 rounded-lg shadow">
        <!-- Images -->
        <div>
            <div class="h-96 bg-gray-300 rounded-lg mb-4 flex items-center justify-center">
                <span class="text-6xl">🌿</span>
            </div>
            @if($product->images->count() > 0)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->images as $image)
                <div class="h-20 bg-gray-200 rounded cursor-pointer hover:opacity-75"></div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <div class="mb-4">
                <p class="text-gray-600">by <a href="#" class="text-green-700 font-semibold hover:underline">{{ $product->vendor->business_name }}</a></p>
            </div>
            <div class="mb-6 flex items-center">
                <div class="text-yellow-400 text-lg">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($product->rating)) ⭐ @else ☆ @endif
                        @endfor
                </div>
                <span class="ml-2 text-gray-600">({{ $product->reviews->count() }} reviews)</span>
            </div>
            <div class="mb-6">
                <div class="text-4xl font-bold text-green-700 mb-2">KES {{ number_format($product->price) }}</div>
            </div>
            <div class="mb-6">
                @if($product->stock > 0)
                <p class="text-green-600 font-semibold">✓ In Stock ({{ $product->stock }} available)</p>
                @else
                <p class="text-red-600 font-semibold">✗ Out of Stock</p>
                @endif
            </div>
            <div class="mb-8">
                <h3 class="font-semibold text-lg mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
            </div>
            @if($product->vendor->approval_status !== 'approved')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <span class="mr-2 text-xl">🚫</span>
                <span>This vendor is currently suspended. Purchases are temporarily disabled.</span>
            </div>
            <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed mb-6">Vendor Suspended</button>
            @elseif($product->stock > 0)
            <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="flex gap-4 items-center">
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                        class="w-16 px-3 py-2 border border-gray-300 rounded-lg">
                    <button type="submit" class="flex-1 bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                        Add to Cart
                    </button>
                </div>
            </form>
            @else
            <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed mb-6">Out of Stock</button>
            @endif
            <div class="border-t pt-6">
                <p class="text-gray-600 mb-3">Share this product:</p>
                <div class="flex gap-3">
                    <button class="text-blue-600 hover:text-blue-800">📘 Facebook</button>
                    <button class="text-blue-400 hover:text-blue-600">🐦 Twitter</button>
                    <button class="text-green-600 hover:text-green-800">💬 WhatsApp</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-8">Related Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
            <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
                <div class="h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center"><span class="text-4xl">🌿</span></div>
                <h3 class="font-semibold mb-1">{{ $related->name }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ $related->vendor->business_name }}</p>
                <p class="text-green-700 font-bold">KES {{ number_format($related->price) }}</p>
                <form action="{{ route('cart.add') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $related->id }}">
                    <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 text-sm transition">Add to Cart</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection