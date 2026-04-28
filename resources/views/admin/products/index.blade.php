@extends('layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Product Moderation</h1>
    <p class="text-gray-600">Review and moderate all marketplace products</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Product</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Vendor</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Category</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Price</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Status</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                    <div class="text-xs text-gray-500">SKU: #{{ $product->id }}</div>
                </td>
                <td class="px-6 py-4 text-sm">
                    <a href="{{ route('admin.vendors.show', $product->vendor) }}" class="text-purple-600 hover:underline">
                        {{ $product->vendor->business_name }}
                    </a>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $product->category->name }}
                </td>
                <td class="px-6 py-4 font-medium">KES {{ number_format($product->price) }}</td>
                <td class="px-6 py-4">
                    <form action="{{ route('admin.products.status', $product) }}" method="POST" class="inline">
                        @csrf
                        <select name="status" onchange="this.form.submit()" class="text-xs border rounded px-2 py-1 {{ $product->status === 'active' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800' }}">
                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ $product->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                    </form>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm mr-3">View</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection