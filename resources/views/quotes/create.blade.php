@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-green-800 px-8 py-10 text-white">
                <h1 class="text-3xl font-black mb-2">Request a Custom Quote</h1>
                <p class="text-green-100 opacity-90">Describe your landscaping needs and vendors will send you their proposals.</p>
            </div>

            <form action="{{ route('quotes.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Service Category</label>
                    <select name="category_id" id="category_id" class="w-full bg-gray-50 border-0 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-green-600 transition-all cursor-pointer @error('category_id') ring-2 ring-red-500 @enderror" required>
                        <option value="" disabled selected>Select a category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Project Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" placeholder="e.g. Karen, Nairobi" class="w-full bg-gray-50 border-0 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-green-600 transition-all @error('location') ring-2 ring-red-500 @enderror" required>
                    @error('location')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Detailed Requirements</label>
                    <textarea name="description" id="description" rows="6" placeholder="Describe the work in detail (e.g. dimensions, preferred plants, current state of the garden)..." class="w-full bg-gray-50 border-0 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-green-600 transition-all @error('description') ring-2 ring-red-500 @enderror" required>{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Minimum 20 characters.</p>
                </div>

                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Project Photo (Optional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-100 border-dashed rounded-2xl bg-gray-50 hover:bg-white hover:border-green-300 transition-all cursor-pointer relative">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <span class="relative cursor-pointer bg-transparent rounded-md font-medium text-green-700 hover:text-green-500 focus-within:outline-none">
                                    Upload a file
                                </span>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                        </div>
                        <input id="image" name="image" type="file" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    @error('image')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 flex items-center justify-between gap-4">
                    <a href="{{ route('quotes.index') }}" class="text-gray-500 font-bold hover:text-gray-700 transition-all">Cancel</a>
                    <button type="submit" class="bg-green-800 text-white font-black px-10 py-4 rounded-2xl hover:scale-105 hover:bg-green-700 active:scale-95 transition-all shadow-lg">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection