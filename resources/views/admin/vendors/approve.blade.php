@extends('layouts.admin')

@section('title', 'Approve Vendor')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-green-600 hover:text-green-800 mb-4 inline-block">← Back to Vendor</a>
        <h1 class="text-3xl font-bold">Approve Vendor</h1>
    </div>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <h3 class="text-red-800 font-bold mb-2">Please fix the following errors:</h3>
        <ul class="list-disc pl-5 text-red-700">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Vendor Summary -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-xl font-bold mb-4">Vendor Summary</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-600">Business Name</label>
                    <p class="text-gray-900">{{ $vendor->business_name }}</p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Owner</label>
                    <p class="text-gray-900">{{ $vendor->user->name }}</p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Email</label>
                    <p class="text-gray-900">{{ $vendor->user->email }}</p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Location</label>
                    <p class="text-gray-900">{{ $vendor->location }}</p>
                </div>
                <div class="col-span-2"><label class="block text-sm font-semibold text-gray-600">Description</label>
                    <p class="text-gray-900">{{ $vendor->description }}</p>
                </div>
            </div>
        </div>

        <!-- Approval Form -->
        <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%) <span class="text-red-600">*</span></label>
                <div class="flex items-center gap-4">
                    <input type="number" id="commission_rate" name="commission_rate" value="{{ old('commission_rate', 15) }}"
                        min="0" max="100" step="0.1" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <span class="text-gray-600">%</span>
                </div>
                <p class="text-gray-500 text-sm mt-2">Platform commission on each sale. Typical range: 10-20%</p>
                @error('commission_rate') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Internal Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Add any internal notes about this vendor...">{{ old('notes') }}</textarea>
                @error('notes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 text-sm"><strong>Note:</strong> Approving this vendor will send them a notification email and allow them to start listing products and services.</p>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">Approve Vendor</button>
                <a href="{{ route('admin.vendors.show', $vendor) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection