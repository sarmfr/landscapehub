@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="{{ route('profile.show') }}" class="text-green-700 hover:underline font-bold">← Back to Dashboard</a>
        <h1 class="text-3xl font-black mt-2 text-gray-900">Edit Personal Information</h1>
        <p class="text-gray-500 italic">Keep your contact details up to date for better communication with professionals.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border p-8 md:p-12">
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 italic bg-gray-50 @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 italic bg-gray-50 @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +254 700 000000"
                        class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 italic bg-gray-50 @error('phone') border-red-500 @enderror">
                    @error('phone') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-green-900 text-white py-4 rounded-2xl font-black text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                        Save Changes
                    </button>
                    <a href="{{ route('profile.show') }}" class="block text-center mt-4 text-gray-500 font-bold hover:text-gray-700">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection