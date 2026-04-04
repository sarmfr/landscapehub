@extends('layouts.vendor')

@section('title', 'Create Product')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('vendor.products.index') }}" class="text-green-600 hover:text-green-800 mb-4 inline-block">← Back to Products</a>
        <h1 class="text-3xl font-bold">Create New Product</h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <h3 class="text-red-800 font-bold mb-2">Please fix the following errors:</h3>
        <ul class="list-disc pl-5 text-red-700">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name <span class="text-red-600">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="e.g., Premium Landscape Soil">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-600">*</span></label>
                <select id="category_id" name="category_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description <span class="text-red-600">*</span></label>
                <textarea id="description" name="description" rows="5" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Describe your product in detail...">{{ old('description') }}</textarea>
                <p class="text-gray-500 text-sm mt-1">Minimum 20 characters</p>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (KES) <span class="text-red-600">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0.01" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="0.00">
                    @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity <span class="text-red-600">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock') }}" min="0" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="0">
                    @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Product Images <span class="text-red-600">*</span></label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-green-600 transition" id="dropZone">
                    <div class="text-gray-600">
                        <p class="text-lg mb-2">Drag and drop images here or click to select</p>
                        <p class="text-sm">JPEG, PNG, JPG, GIF — Max 5MB each — Max 10 images</p>
                    </div>
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" required>
                </div>
                <div id="imagePreview" class="mt-4 grid grid-cols-2 gap-4"></div>
                @error('images') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">Create Product</button>
                <a href="{{ route('vendor.products.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(e => {
        dropZone.addEventListener(e, ev => {
            ev.preventDefault();
            ev.stopPropagation();
        });
    });
    ['dragenter', 'dragover'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.add('border-green-600', 'bg-green-50')));
    ['dragleave', 'drop'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('border-green-600', 'bg-green-50')));
    dropZone.addEventListener('drop', e => {
        fileInput.files = e.dataTransfer.files;
        displayPreviews();
    });
    dropZone.addEventListener('click', () => fileInput.click());
    fileInput.addEventListener('change', displayPreviews);

    function displayPreviews() {
        imagePreview.innerHTML = '';
        [...fileInput.files].slice(0, 10).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative';
                if (i === 0) {
                    const b = document.createElement('span');
                    b.className = 'absolute top-2 right-2 bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold';
                    b.textContent = 'Primary';
                    div.appendChild(b);
                }
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-32 object-cover rounded-lg border border-gray-200';
                div.appendChild(img);
                imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush