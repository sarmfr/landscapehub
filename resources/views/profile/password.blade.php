@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('profile.show') }}" class="text-green-700 hover:underline font-bold">← Back to Dashboard</a>
        <h1 class="text-3xl font-black mt-2 text-gray-900">Secure Your Account</h1>
        <p class="text-gray-500 italic">Ensure your account is protected with a strong, unique password.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border p-8 md:p-12">
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="current_password" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 bg-gray-50 @error('current_password') border-red-500 @enderror">
                    @error('current_password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="border-t pt-6">
                    <label for="password" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">New Password Index</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 bg-gray-50 @error('password') border-red-500 @enderror">
                    @error('password') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 bg-gray-50">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-green-900 text-white py-4 rounded-2xl font-black text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                        Update Password
                    </button>
                    <a href="{{ route('profile.show') }}" class="block text-center mt-4 text-gray-500 font-bold hover:text-gray-700">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection