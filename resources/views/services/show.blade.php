@extends('layouts.app')

@section('title', $service->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <div class="mb-8 text-gray-600 text-sm">
        <a href="{{ route('home') }}" class="hover:text-green-700">Home</a> /
        <a href="{{ route('services') }}" class="hover:text-green-700">Services</a> /
        <span>{{ $service->name }}</span>
    </div>

    <!-- Service Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Image -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border overflow-hidden">
            <div class="h-96 bg-gray-100 rounded-xl overflow-hidden">
                @if($service->image_path)
                <img src="{{ $service->image_path }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-6xl">🏗</div>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border">
            <h1 class="text-3xl font-bold mb-2 text-gray-900">{{ $service->name }}</h1>
            <div class="mb-6">
                <p class="text-gray-600 flex items-center">
                    <span class="mr-2">🏪</span>
                    by <a href="#" class="text-green-700 font-bold hover:underline ml-1">{{ $service->vendor->business_name }}</a>
                </p>
                <p class="text-gray-500 text-sm mt-1">📍 Located in {{ $service->vendor->location }}</p>
            </div>
            <div class="mb-8 flex items-center">
                <div class="text-yellow-400 text-lg">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < floor($service->rating)) ⭐ @else ☆ @endif
                        @endfor
                </div>
                <span class="ml-2 text-gray-500 font-medium">({{ $service->reviews->count() }} reviews)</span>
            </div>
            <div class="mb-8">
                @if($service->pricing_type === 'fixed')
                <p class="text-sm text-gray-500 uppercase font-black tracking-widest mb-1">Pricing Starts From</p>
                <div class="text-4xl font-black text-green-800">KES {{ number_format($service->price) }}</div>
                @else
                <div class="bg-green-50 border border-green-100 text-green-800 p-6 rounded-2xl">
                    <h3 class="font-bold mb-1">Custom Quote Service</h3>
                    <p class="text-sm opacity-90">Book today to receive a personalized quote based on your specific requirements.</p>
                </div>
                @endif
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-gray-900 mb-2">Service Description</h3>
                <p class="text-gray-600 leading-relaxed">{{ $service->description }}</p>
            </div>
            <div class="mb-8 border-t pt-8">
                <h3 class="font-bold text-gray-900 mb-4">Service Provider Details</h3>
                <div class="space-y-3">
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $service->vendor->description }}</p>
                    <div class="flex items-center text-gray-700">
                        <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-700">📞</span>
                        <a href="tel:{{ $service->vendor->business_phone }}" class="hover:text-green-700 font-mediumTransition transition">
                            {{ $service->vendor->business_phone ?? 'Contact via platform' }}
                        </a>
                    </div>
                </div>
            </div>
            @if($service->vendor->approval_status !== 'approved')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <span class="mr-2 text-xl">🚫</span>
                <span>This vendor is currently suspended. Bookings are temporarily disabled.</span>
            </div>
            <button disabled class="block text-center w-full bg-gray-400 text-white py-4 rounded-xl font-bold text-lg cursor-not-allowed">
                Service Unavailable
            </button>
            @else
            @auth
            <a href="{{ route('bookings.create', $service->id) }}" class="block text-center w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                Book This Service Now
            </a>
            @else
            <a href="{{ route('login') }}" class="block text-center w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg">
                Login to Book Service
            </a>
            @endauth
            @endif
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12 bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
        @if($service->reviews->count() > 0)
        <div class="space-y-6">
            @foreach($service->reviews as $review)
            <div class="border-b pb-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold">{{ $review->user->name }}</h4>
                    <span class="text-yellow-400">@for($i = 0; $i < $review->rating; $i++)⭐@endfor</span>
                </div>
                <p class="text-gray-500 text-sm mb-2">{{ $review->created_at->format('M d, Y') }}</p>
                <p class="text-gray-700">{{ $review->comment }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-600">No reviews yet. Be the first to review this service!</p>
        @endif
    </div>
</div>
@endsection