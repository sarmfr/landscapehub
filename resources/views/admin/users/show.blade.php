@extends('layouts.admin')

@section('title', $user->name . ' - User Details')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-500 text-sm">Joined {{ $user->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>
    <div class="flex gap-4">
        <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition">← Back to Users</a>
        <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">Edit User</a>
        @if(!$user->isAdmin())
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this user?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Delete User</button>
        </form>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Account Info Panel -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Account Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $user->email }}
                        @if($user->is_verified) <span class="text-green-600 text-xs ml-1">✓ Verified</span> @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Role</p>
                    @if($user->isAdmin())
                    <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                    @elseif($user->isVendor())
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Vendor</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Customer</span>
                    @endif
                </div>
            </div>
        </div>

        @if($user->isVendor() && $user->vendor)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Vendor Details</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Business Name</p>
                    <p class="font-medium">{{ $user->vendor->business_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    @if($user->vendor->approval_status === 'approved')
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                    @elseif($user->vendor->approval_status === 'pending')
                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                    @else
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold capitalize">{{ $user->vendor->approval_status }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Commission Rate</p>
                    <p class="font-medium">{{ $user->vendor->commission_rate }}%</p>
                </div>
                <a href="{{ route('admin.vendors.show', $user->vendor) }}" class="inline-block mt-2 text-green-600 hover:text-green-800 font-medium text-sm">View Full Vendor Profile →</a>
            </div>
        </div>
        @endif
    </div>

    <!-- Activity Panel -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold">Recent Orders</h2>
                <span class="text-sm text-gray-500">{{ $user->orders->count() }} total</span>
            </div>
            @if($user->orders->count() > 0)
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 text-xs uppercase">
                        <th class="pb-2">Order</th>
                        <th class="pb-2">Date</th>
                        <th class="pb-2">Amount</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($user->orders->take(5) as $order)
                    <tr>
                        <td class="py-2 text-green-600 font-medium">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="py-2 text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="py-2">KES {{ number_format($order->total_amount, 2) }}</td>
                        <td class="py-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="text-gray-500 text-center py-4">No orders placed yet.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold">Recent Reviews</h2>
                <span class="text-sm text-gray-500">{{ $user->reviews->count() }} total</span>
            </div>
            @if($user->reviews->count() > 0)
            <div class="space-y-4">
                @foreach($user->reviews->take(3) as $review)
                <div class="bg-gray-50 p-4 rounded-lg text-sm">
                    <div class="flex justify-between items-start mb-2">
                        <div class="text-yellow-400">@for($i = 0; $i < 5; $i++){{ $i < $review->rating ? '★' : '☆' }}@endfor</div>
                                <span class="text-gray-400 text-xs">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">"{{ \Illuminate\Support\Str::limit($review->comment, 150) }}"</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-4">No reviews yet.</p>
                @endif
            </div>
        </div>
    </div>
    @endsection