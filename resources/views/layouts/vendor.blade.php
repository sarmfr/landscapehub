<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vendor Dashboard') - LandScapeHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-green-800">🌿 LandScapeHub</a>

            <nav class="hidden md:flex items-center space-x-4 text-sm font-medium">
                <a href="{{ route('vendor.dashboard') }}"
                    class="px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.dashboard') ? 'bg-green-100 text-green-800 font-semibold' : 'text-gray-600 hover:text-green-700 hover:bg-gray-100' }}">
                    📊 Dashboard
                </a>
                @if(Auth::user()->vendor && Auth::user()->vendor->approval_status !== 'suspended')
                <a href="{{ route('vendor.products.index') }}"
                    class="px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.products*') ? 'bg-green-100 text-green-800 font-semibold' : 'text-gray-600 hover:text-green-700 hover:bg-gray-100' }}">
                    📦 Products
                </a>
                <a href="{{ route('vendor.services.index') }}"
                    class="px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.services*') ? 'bg-green-100 text-green-800 font-semibold' : 'text-gray-600 hover:text-green-700 hover:bg-gray-100' }}">
                    🏗 Services
                </a>
                <a href="{{ route('vendor.quotes.index') }}"
                    class="px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.quotes*') ? 'bg-green-100 text-green-800 font-semibold' : 'text-gray-600 hover:text-green-700 hover:bg-gray-100' }}">
                    💬 Quotes
                </a>
                <a href="{{ route('vendor.profile.show') }}"
                    class="px-3 py-2 rounded-lg transition {{ request()->routeIs('vendor.profile*') ? 'bg-green-100 text-green-800 font-semibold' : 'text-gray-600 hover:text-green-700 hover:bg-gray-100' }}">
                    👤 Profile
                </a>
                @endif
                <a href="{{ route('home') }}" class="px-3 py-2 text-gray-500 hover:text-green-700 transition">🌐 Store</a>
                <div class="h-5 w-px bg-gray-300 mx-1"></div>
                <span class="text-gray-700 font-medium">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm transition">Logout</button>
                </form>
            </nav>

            <!-- Mobile menu button -->
            <button onclick="document.getElementById('vendor-mobile-menu').classList.toggle('hidden')" class="md:hidden text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="vendor-mobile-menu" class="hidden md:hidden bg-white border-t px-6 py-3 space-y-2">
            <a href="{{ route('vendor.dashboard') }}" class="block py-2 text-gray-700 hover:text-green-700">📊 Dashboard</a>
            @if(Auth::user()->vendor && Auth::user()->vendor->approval_status !== 'suspended')
            <a href="{{ route('vendor.products.index') }}" class="block py-2 text-gray-700 hover:text-green-700">📦 Products</a>
            <a href="{{ route('vendor.services.index') }}" class="block py-2 text-gray-700 hover:text-green-700">🏗 Services</a>
            <a href="{{ route('vendor.quotes.index') }}" class="block py-2 text-gray-700 hover:text-green-700">💬 Quotes</a>
            <a href="{{ route('vendor.profile.show') }}" class="block py-2 text-gray-700 hover:text-green-700">👤 Profile</a>
            @endif
            <a href="{{ route('home') }}" class="block py-2 text-gray-500 hover:text-green-700">🌐 Visit Store</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800 py-2">Logout</button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>