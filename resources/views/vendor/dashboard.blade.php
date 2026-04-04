@extends('layouts.vendor')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Vendor Dashboard</h1>
    <p class="text-gray-600">Welcome, {{ $vendor->business_name }}</p>
</div>

@if($vendor->approval_status === 'suspended')
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-6 mb-8 rounded-r-lg shadow-sm">
    <div class="flex items-center mb-2">
        <span class="text-2xl mr-3">!</span>
        <h3 class="text-xl font-bold">Account Suspended</h3>
    </div>
    <p class="mb-4">Your account has been suspended by the administrator. You cannot manage products, services, or edit your profile during this time.</p>
    <div class="bg-white bg-opacity-50 p-3 rounded border border-red-200 inline-block font-semibold">
        To resolve this, please contact: <a href="mailto:admin@landscapehub.com" class="underline hover:text-red-900">admin@landscapehub.com</a>
    </div>
</div>
@elseif($vendor->approval_status !== 'approved')
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
    <p class="font-bold">Approval Status: {{ ucfirst($vendor->approval_status) }}</p>
    <p>Your vendor profile is awaiting admin approval. You'll be able to add products once approved.</p>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Total Products</div>
        <div class="text-3xl font-bold text-green-700">{{ $totalProducts }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Total Services</div>
        <div class="text-3xl font-bold text-green-700">{{ $totalServices }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Total Earnings</div>
        <div class="text-3xl font-bold text-green-700">KES {{ number_format($totalEarnings) }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Average Rating</div>
        <div class="text-3xl font-bold text-green-700">{{ $averageRating }}/5</div>
    </div>
</div>

@if($pendingBookings > 0)
<div class="bg-blue-100 border border-blue-300 rounded-lg p-6 mb-8">
    <p class="text-blue-800">
        <strong>{{ $pendingBookings }} pending booking{{ $pendingBookings !== 1 ? 's' : '' }}</strong> - Review and respond to service booking requests
    </p>
</div>
@endif

@if($vendor->approval_status === 'approved')
<div class="flex gap-4 mb-8">
    <a href="{{ route('vendor.products.create') }}" class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800">
        + Add Product
    </a>
    <a href="{{ route('vendor.services.create') }}" class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800">
        + Add Service
    </a>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('vendor.products.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">Manage Products</h3>
        <p class="text-gray-600 text-sm">Add, edit, or remove products from your shop</p>
    </a>
    <a href="{{ route('vendor.services.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">Manage Services</h3>
        <p class="text-gray-600 text-sm">Manage your landscaping services and pricing</p>
    </a>
    <a href="{{ route('vendor.profile.show') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">My Profile</h3>
        <p class="text-gray-600 text-sm">View and update your vendor business profile</p>
    </a>
</div>
@endsection
