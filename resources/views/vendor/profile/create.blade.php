@extends('layouts.vendor')

@section('title', 'Create Vendor Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Create Your Vendor Profile</h1>
        <p class="text-gray-600 mb-8">Complete your vendor information to start selling on LandScapeHub</p>

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

        <form action="{{ route('vendor.profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="business_name" class="block text-sm font-medium text-gray-700 mb-2">Business Name <span class="text-red-600">*</span></label>
                <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="e.g., Green Gardens Ltd">
                @error('business_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Business Description <span class="text-red-600">*</span></label>
                <textarea id="description" name="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Tell customers about your landscaping services...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Service Area <span class="text-red-600">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="e.g., Nairobi, Kenya">
                @error('location') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="business_phone" class="block text-sm font-medium text-gray-700 mb-2">Business Phone <span class="text-red-600">*</span></label>
                <input type="tel" id="business_phone" name="business_phone" value="{{ old('business_phone') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="+254 700 000000">
                @error('business_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="business_address" class="block text-sm font-medium text-gray-700 mb-2">Business Address <span class="text-red-600">*</span></label>
                <textarea id="business_address" name="business_address" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Enter your physical business address">{{ old('business_address') }}</textarea>
                @error('business_address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-2">Business Logo/Photo</label>
                <input type="file" id="profile_image" name="profile_image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                <p class="text-gray-500 text-sm mt-1">Accepted: JPEG, PNG, JPG, GIF (Max 2MB)</p>
                @error('profile_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-800 text-sm"><strong>Note:</strong> Your vendor profile is pending admin approval. You'll receive a notification once approved.</p>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">Create Profile</button>
                <a href="{{ route('home') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection