@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">Edit User</h1>
    <a href="{{ route('admin.users.show', $user) }}" class="text-green-600 hover:text-green-800 text-sm">← Back to User Details</a>
</div>

<div class="max-w-2xl">
    @if($user->isAdmin())
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 mb-6 rounded-r-lg">
        <p><strong>Note:</strong> You are editing an admin user. Be cautious with role changes.</p>
    </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow p-6 space-y-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('name') border-red-500 @enderror">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('phone') border-red-500 @enderror">
                @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                <select name="role" id="role" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 @error('role') border-red-500 @enderror">
                    <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="vendor" {{ old('role', $user->role) === 'vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_verified" id="is_verified" value="1" {{ old('is_verified', $user->is_verified) ? 'checked' : '' }}
                    class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-600">
                <label for="is_verified" class="ml-2 text-sm text-gray-700">Email Verified</label>
            </div>

            <div class="border-t pt-6 flex gap-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition">
                    Update User
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
