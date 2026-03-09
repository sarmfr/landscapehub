@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-purple-700 hover:underline">← Back to Categories</a>
        <h1 class="text-3xl font-bold mt-2">Edit Category: {{ $category->name }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Icon (Emoji or FontAwesome class)</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Type</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600">
                    <option value="product" {{ old('type', $category->type) === 'product' ? 'selected' : '' }}>Product Only</option>
                    <option value="service" {{ old('type', $category->type) === 'service' ? 'selected' : '' }}>Service Only</option>
                    <option value="both" {{ old('type', $category->type) === 'both' ? 'selected' : '' }}>Both</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600">{{ old('description', $category->description) }}</textarea>
            </div>

            <button type="submit" class="w-full bg-purple-700 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                Update Category
            </button>
        </form>
    </div>
</div>
@endsection