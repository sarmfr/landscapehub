@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">User Management</h1>
    <a href="{{ route('admin.dashboard') }}" class="text-green-600 hover:text-green-800 text-sm">← Back to Dashboard</a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" class="flex gap-4 flex-wrap">
        <div class="flex-1 min-w-64">
            <input type="text" name="search" placeholder="Search by name or email..." value="{{ request('search') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>
        <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
            <option value="">All Roles</option>
            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
            <option value="vendor" {{ request('role') === 'vendor' ? 'selected' : '' }}>Vendor</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
        @if(request()->hasAny(['search', 'role']))
        <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 py-2 px-4">Clear</a>
        @endif
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-4 text-left font-semibold">User</th>
                <th class="px-6 py-4 text-left font-semibold">Role</th>
                <th class="px-6 py-4 text-left font-semibold">Joined</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-lg flex-shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($user->isAdmin())
                    <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                    @elseif($user->isVendor())
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Vendor</span>
                    @else
                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Customer</span>
                    @endif
                    @if($user->is_verified)
                    <span class="ml-1 text-green-600 text-xs">✓ Verified</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm mr-3">View</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm mr-3">Edit</a>
                    @if(!$user->isAdmin())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                        onsubmit="return confirm('Delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No users found matching your criteria.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="mt-6">{{ $users->withQueryString()->links() }}</div>
@endif
@endsection