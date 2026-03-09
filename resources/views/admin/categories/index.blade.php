@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold">Categories</h1>
        <p class="text-gray-600">Manage product and service categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-800 transition">
        + Add New Category
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Icon</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Name</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Type</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Items</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($categories as $category)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-2xl">{{ $category->icon ?: '📁' }}</td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                    <div class="text-xs text-gray-500">{{ $category->slug }}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold uppercase {{ $category->type === 'product' ? 'bg-blue-100 text-blue-800' : ($category->type === 'service' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $category->type }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $category->products_count }} products, {{ $category->services_count }} services
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No categories found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection