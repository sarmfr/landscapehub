@extends('layouts.admin')

@section('title', 'Vendor Management')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Vendor Management</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:text-green-800 text-sm">← Back to Dashboard</a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" class="flex gap-4 flex-wrap">
        <div class="flex-1 min-w-64">
            <input type="text" name="search" placeholder="Search by business name or owner..." value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
    </form>
</div>

<!-- Vendors Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-4 text-left font-semibold">Business Name</th>
                <th class="px-6 py-4 text-left font-semibold">Owner</th>
                <th class="px-6 py-4 text-left font-semibold">Location</th>
                <th class="px-6 py-4 text-left font-semibold">Status</th>
                <th class="px-6 py-4 text-left font-semibold">Commission</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vendors as $vendor)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if ($vendor->profile_image)
                        <img src="{{ asset('storage/' . $vendor->profile_image) }}" alt="Logo" class="h-8 w-8 rounded object-cover">
                        @else
                        <div class="h-8 w-8 rounded bg-gray-300"></div>
                        @endif
                        {{ $vendor->business_name }}
                    </div>
                </td>
                <td class="px-6 py-4">{{ $vendor->user->name }}</td>
                <td class="px-6 py-4">{{ $vendor->location }}</td>
                <td class="px-6 py-4">
                    @if ($vendor->approval_status === 'pending')
                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                    @elseif ($vendor->approval_status === 'approved')
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                    @elseif ($vendor->approval_status === 'rejected')
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Rejected</span>
                    @elseif ($vendor->approval_status === 'suspended')
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">Suspended</span>
                    @endif
                </td>
                <td class="px-6 py-4">{{ $vendor->commission_rate }}%</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm">View</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No vendors found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($vendors->hasPages())
<div class="mt-6">{{ $vendors->links() }}</div>
@endif
@endsection