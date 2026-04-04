@extends('layouts.app')

@section('title', 'LandScapeHub - Kenya\'s #1 Landscaping Marketplace')

@section('content')
<section class="relative bg-green-900 text-white py-32 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/hero-bg.png') }}" alt="Beautiful Landscaping" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg">
            Kenya's #1 Landscaping Marketplace
        </h1>
        <p class="text-xl md:text-2xl mb-10 text-gray-100 max-w-3xl mx-auto drop-shadow-md">
            Find professional landscapers or shop quality garden products near you.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('services') }}" class="bg-white text-green-900 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl transform hover:-translate-y-1">
                Browse Services
            </a>
            <a href="{{ route('products') }}" class="bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-xl transform hover:-translate-y-1">
                Shop Products
            </a>
        </div>
    </div>
</section>

<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-12 text-center text-green-900">Popular Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <a href="{{ route('products') }}?category=plants" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="{{ asset('images/categories/plants.png') }}" alt="Plants" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-sm mb-4 uppercase tracking-[0.3em] text-white/80">Category</span>
                    <h3 class="text-xl font-bold text-white mb-2">Plants & Flowers</h3>
                    <p class="text-white text-sm opacity-90">Enhance your garden with vibrant life.</p>
                </div>
            </a>

            <a href="{{ route('products') }}?category=tools" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="{{ asset('images/categories/tools.png') }}" alt="Garden Tools" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-sm mb-4 uppercase tracking-[0.3em] text-white/80">Category</span>
                    <h3 class="text-xl font-bold text-white mb-2">Garden Tools</h3>
                    <p class="text-white text-sm opacity-90">The right tools for every garden task.</p>
                </div>
            </a>

            <a href="{{ route('products') }}?category=irrigation" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="{{ asset('images/categories/irrigation.png') }}" alt="Irrigation" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-sm mb-4 uppercase tracking-[0.3em] text-white/80">Category</span>
                    <h3 class="text-xl font-bold text-white mb-2">Irrigation</h3>
                    <p class="text-white text-sm opacity-90">Keep your landscape lush and watered.</p>
                </div>
            </a>

            <a href="{{ route('services') }}" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="{{ asset('images/vendor-bg.png') }}" alt="Landscaping Services" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-sm mb-4 uppercase tracking-[0.3em] text-white/80">Category</span>
                    <h3 class="text-xl font-bold text-white mb-2">Landscaping Services</h3>
                    <p class="text-white text-sm opacity-90">Professional design and maintenance.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Trending Products</h2>
            <a href="{{ route('products') }}" class="text-green-700 hover:underline">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($trendingProducts as $product)
            <div class="bg-white rounded-xl shadow-sm border p-4 hover:shadow-lg transition group">
                <div class="h-48 bg-gray-200 rounded-lg mb-4 overflow-hidden relative">
                    @if($product->getPrimaryImage())
                    <img src="{{ $product->getPrimaryImage() }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-sm text-gray-500">No image</div>
                    @endif
                </div>
                <h3 class="font-bold text-gray-900">{{ $product->name }}</h3>
                <p class="text-gray-500 text-sm mb-2">by {{ $product->vendor->business_name }}</p>
                <div class="flex justify-between items-center mt-3">
                    <p class="text-green-800 font-black">KES {{ number_format($product->price) }}</p>
                    @if($product->vendor->approval_status !== 'approved')
                    <span class="text-xs text-red-600 font-bold bg-red-50 px-2 py-1 rounded">Suspended</span>
                    @else
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="bg-green-100 text-green-800 px-3 py-2 rounded-lg hover:bg-green-700 hover:text-white transition text-sm font-semibold">
                            Add
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <p class="col-span-4 text-center text-gray-500 py-12">No products available yet</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-12 text-center md:text-left flex-col md:flex-row gap-4">
            <h2 class="text-3xl font-bold text-green-900">Popular Services</h2>
            <a href="{{ route('services') }}" class="text-green-700 font-bold hover:underline">View All Services</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($popularServices as $service)
            <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition group">
                <div class="h-56 bg-gray-300 relative overflow-hidden">
                    @if($service->getImageUrl())
                    <img src="{{ $service->getImageUrl() }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-sm text-gray-500">No image</div>
                    @endif
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-800 shadow-sm uppercase">
                            {{ $service->pricing_type }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-2">{{ $service->name }}</h3>
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <span class="mr-2 font-semibold">Vendor:</span>
                        {{ $service->vendor->business_name }}
                    </div>

                    <div class="flex items-center justify-between border-t pt-4">
                        <div>
                            @if($service->pricing_type === 'fixed')
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Starting from</p>
                            <p class="text-green-800 font-black text-xl">KES {{ number_format($service->price) }}</p>
                            @else
                            <p class="text-green-800 font-bold">Custom Quote</p>
                            @endif
                        </div>
                        @if($service->vendor->approval_status !== 'approved')
                        <span class="text-xs text-red-600 font-bold bg-red-50 px-3 py-2 rounded-lg">Suspended</span>
                        @else
                        <a href="{{ route('services.show', $service->slug) }}" class="bg-green-700 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-800 transition">
                            Book Now
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-500 py-12">No services available yet</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-12">How It Works</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <div class="text-lg font-bold mb-4 text-green-700">1</div>
                <h3 class="font-semibold mb-2">Browse</h3>
                <p class="text-gray-600">Search for products or professional landscapers in your area.</p>
            </div>
            <div>
                <div class="text-lg font-bold mb-4 text-green-700">2</div>
                <h3 class="font-semibold mb-2">Order / Book</h3>
                <p class="text-gray-600">Add to cart or book services easily with just a few clicks.</p>
            </div>
            <div>
                <div class="text-lg font-bold mb-4 text-green-700">3</div>
                <h3 class="font-semibold mb-2">Enjoy Results</h3>
                <p class="text-gray-600">Receive quality products or expert landscaping services.</p>
            </div>
        </div>
    </div>
</section>

<section class="relative bg-green-800 text-white py-20 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/vendor-bg.png') }}" alt="Landscaping Professional" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-green-900 opacity-70"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 drop-shadow-md">Want to become a vendor?</h2>
        <p class="text-lg mb-8 text-green-50 max-w-2xl mx-auto drop-shadow-sm">Join Kenya's leading landscaping marketplace and grow your business by reaching thousands of customers.</p>
        <a href="{{ route('register') }}" class="bg-white text-green-800 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl inline-block transform hover:-translate-y-1">
            Join as Vendor Today
        </a>
    </div>
</section>
@endsection
