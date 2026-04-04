@extends('layouts.vendor')

@section('title', 'Add New Service')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-1">Add New Service</h1>
        <a href="{{ route('vendor.services.index') }}" class="text-green-600 hover:text-green-800 text-sm">← Back to Services</a>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <ul class="list-disc list-inside text-red-700 space-y-1">
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('vendor.services.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Service Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('name') border-red-400 @enderror"
                    placeholder="e.g. Lawn Mowing, Garden Design, Tree Trimming">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                <select id="category_id" name="category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="6"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Describe your service in detail (at least 20 characters)...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pricing Type <span class="text-red-500">*</span></label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pricing_type" value="fixed" {{ old('pricing_type', 'fixed') === 'fixed' ? 'checked' : '' }} onchange="togglePriceField()" class="w-4 h-4 text-green-600">
                        <span class="font-medium">Fixed Price</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="pricing_type" value="quote" {{ old('pricing_type') === 'quote' ? 'checked' : '' }} onchange="togglePriceField()" class="w-4 h-4 text-green-600">
                        <span class="font-medium">Quote-Based</span>
                    </label>
                </div>
            </div>
            <div id="price-field" class="mb-6 {{ old('pricing_type') === 'quote' ? 'hidden' : '' }}">
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price (KES) <span class="text-red-500">*</span></label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="0.00">
                @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-8">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active (visible to customers)</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (hidden)</option>
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-8 rounded-lg transition">Create Service</button>
                <a href="{{ route('vendor.services.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-lg transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePriceField() {
        const pricingType = document.querySelector('input[name="pricing_type"]:checked').value;
        document.getElementById('price-field').classList.toggle('hidden', pricingType === 'quote');
    }
</script>
@endpush