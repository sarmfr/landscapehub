@extends('layouts.admin')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-500 text-sm">Product ID: #{{ $product->id }} | Created {{ $product->created_at->format('M d, Y') }}</p>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            View on Site ↗
        </a>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition">← Back</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Product Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-4 border-b pb-4">
                <h2 class="text-xl font-bold">Product Information</h2>
                <form action="{{ route('admin.products.status', $product) }}" method="POST" class="inline">
                    @csrf
                    <select name="status" onchange="this.form.submit()" 
                        class="text-sm border rounded-lg px-3 py-1 font-semibold
                        {{ $product->status === 'active' ? 'bg-green-100 text-green-800 border-green-300' : 
                           ($product->status === 'suspended' ? 'bg-red-100 text-red-800 border-red-300' : 'bg-gray-100 text-gray-800 border-gray-300') }}">
                        <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ $product->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Category</p>
                    <p class="font-medium">{{ $product->category->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Price</p>
                    <p class="font-medium text-green-700">KES {{ number_format($product->price, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stock</p>
                    <p class="font-medium {{ $product->stock < 10 ? 'text-red-600' : 'text-gray-900' }}">
                        {{ $product->stock }} units
                        @if($product->stock < 10)
                            <span class="text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded ml-1">Low Stock</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Views</p>
                    <p class="font-medium">{{ number_format($product->views) }}</p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-1">Description</p>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>
        </div>

        <!-- Images -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Product Images</h2>
            @if($product->images->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($product->images as $image)
                <div class="relative group">
                    <img src="{{ $image->getUrl() }}" alt="Product image" 
                        class="w-full h-32 object-cover rounded-lg border {{ $image->is_primary ? 'border-green-500 ring-2 ring-green-200' : 'border-gray-200' }}">
                    @if($image->is_primary)
                    <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-0.5 rounded">Primary</span>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-center py-4">No images uploaded for this product.</p>
            @endif
        </div>

        <!-- Danger Zone -->
        <div class="bg-white rounded-lg shadow p-6 border border-red-200">
            <h2 class="text-xl font-bold mb-4 text-red-700">Danger Zone</h2>
            <p class="text-gray-600 text-sm mb-4">Deleting a product will remove it from the marketplace. The product will be soft-deleted and can be restored later.</p>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                    Delete Product
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Vendor Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Vendor</h2>
            @if($product->vendor)
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-800 font-bold flex items-center justify-center">
                    {{ strtoupper(substr($product->vendor->business_name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold">{{ $product->vendor->business_name }}</p>
                    <a href="{{ route('admin.vendors.show', $product->vendor) }}" class="text-green-600 hover:text-green-800 text-sm">View Vendor</a>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    @if($product->vendor->approval_status === 'approved')
                    <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-xs font-semibold">Approved</span>
                    @elseif($product->vendor->approval_status === 'suspended')
                    <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded text-xs font-semibold">Suspended</span>
                    @else
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded text-xs font-semibold capitalize">{{ $product->vendor->approval_status }}</span>
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Commission:</span>
                    <span class="font-medium">{{ $product->vendor->commission_rate }}%</span>
                </div>
            </div>
            @else
            <p class="text-gray-500">Vendor information unavailable.</p>
            @endif
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Statistics</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Total Orders</span>
                    <span class="font-bold">{{ $product->orderItems->count() ?? 0 }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Total Sold</span>
                    <span class="font-bold">{{ $product->orderItems->sum('quantity') ?? 0 }} units</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Reviews</span>
                    <span class="font-bold">{{ $product->reviews->count() ?? 0 }}</span>
                </div>
                @if($product->reviews->count() > 0)
                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">Avg Rating</span>
                    <span class="font-bold text-yellow-600">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= round($product->reviews->avg('rating')) ? '★' : '☆' }}
                        @endfor
                        ({{ number_format($product->reviews->avg('rating'), 1) }})
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Reviews -->
        @if($product->reviews->count() > 0)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Recent Reviews</h2>
            <div class="space-y-4">
                @foreach($product->reviews->take(3) as $review)
                <div class="bg-gray-50 p-3 rounded-lg">
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                        </span>
                        <span class="text-gray-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700">{{ Str::limit($review->comment, 80) }}</p>
                    <p class="text-xs text-gray-500 mt-1">- {{ $review->user->name }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
