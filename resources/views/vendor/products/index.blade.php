@extends('layouts.vendor')

@section('title', 'My Products')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-1">My Products</h1>
        <a href="{{ route('vendor.dashboard') }}" class="text-green-600 hover:text-green-800 text-sm">← Back to Dashboard</a>
    </div>
    @if($vendor->approval_status === 'approved')
    <a href="{{ route('vendor.products.create') }}" class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition">
        + Add Product
    </a>
    @endif
</div>

@if($vendor->approval_status !== 'approved')
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
    <p class="font-bold">Approval Required</p>
    <p>Your vendor profile must be approved before you can add products.</p>
</div>
@endif

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-4 text-left font-semibold">Product</th>
                <th class="px-6 py-4 text-left font-semibold">Category</th>
                <th class="px-6 py-4 text-left font-semibold">Price</th>
                <th class="px-6 py-4 text-left font-semibold">Stock</th>
                <th class="px-6 py-4 text-left font-semibold">Status</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category->name ?? '—' }}</td>
                <td class="px-6 py-4 text-green-700 font-semibold">KES {{ number_format($product->price, 2) }}</td>
                <td class="px-6 py-4">
                    <span class="{{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-700' }}">{{ $product->stock }}</span>
                </td>
                <td class="px-6 py-4">
                    @if($product->status === 'active')
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Active</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('vendor.products.edit', $product) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm">Edit</a>
                    <form action="{{ route('vendor.products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Delete this product?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                    No products yet.
                    @if($vendor->approval_status === 'approved')
                    <a href="{{ route('vendor.products.create') }}" class="text-green-600 hover:underline ml-1">Add your first product →</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($products->hasPages())
<div class="mt-6">{{ $products->withQueryString()->links() }}</div>
@endif
@endsection