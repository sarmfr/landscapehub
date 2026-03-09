@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-800">🌿 LandScapeHub</h1>
            <p class="text-gray-600 mt-2">Welcome Back</p>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="you@example.com">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="Enter your password">
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg font-semibold hover:bg-green-800 transition">
                Login
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600">Don't have an account?
                <a href="{{ route('register') }}" class="text-green-700 font-semibold hover:underline">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection