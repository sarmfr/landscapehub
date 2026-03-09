<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LandScapeHub - Kenya\'s #1 Landscaping Marketplace')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans">

    <!-- ================= NAVBAR ================= -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold text-green-800 flex-shrink-0">
                🌿 LandScapeHub
            </a>

            <!-- Search Bar -->
            <div class="flex-1 mx-6 hidden md:block">
                <form action="{{ route('products') }}" method="GET">
                    <input type="text" name="search" placeholder="Search products or services..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
                </form>
            </div>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-4 text-sm font-medium">
                <a href="{{ route('products') }}" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition {{ request()->routeIs('products*') ? 'text-green-700 font-semibold' : '' }}">Products</a>
                <a href="{{ route('services') }}" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition {{ request()->routeIs('services*') ? 'text-green-700 font-semibold' : '' }}">Services</a>
                <a href="{{ route('quotes.index') }}" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition {{ request()->routeIs('quotes*') ? 'text-green-700 font-semibold' : '' }}">Requests</a>

                @auth
                @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-purple-700 hover:text-purple-900 px-2 py-1 rounded transition">Admin</a>
                @elseif(Auth::user()->isVendor())
                <a href="{{ route('vendor.dashboard') }}" class="text-blue-700 hover:text-blue-900 px-2 py-1 rounded transition">Vendor Dashboard</a>
                @endif
                <a href="{{ route('profile.show') }}" class="flex items-center gap-2 group border-l pl-4">
                    <span class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-black group-hover:bg-green-700 group-hover:text-white transition">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    <span class="text-gray-700 font-bold group-hover:text-green-700 transition">My Profile</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 transition">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-700 transition">Login</a>
                <a href="{{ route('register') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">
                    Become Vendor
                </a>
                @endauth

                <!-- Cart -->
                <a href="{{ route('cart.view') }}" class="relative text-2xl ml-2">
                    🛒
                    @if(count(session()->get('cart', [])) > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        {{ count(session()->get('cart', [])) }}
                    </span>
                    @endif
                </a>
            </nav>

            <!-- Mobile Menu Button -->
            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="md:hidden text-gray-700 focus:outline-none ml-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t px-6 py-4 space-y-3 text-sm">
            <form action="{{ route('products') }}" method="GET" class="mb-3">
                <input type="text" name="search" placeholder="Search..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
            </form>
            <a href="{{ route('products') }}" class="block text-gray-700 hover:text-green-700">Products</a>
            <a href="{{ route('services') }}" class="block text-gray-700 hover:text-green-700">Services</a>
            <a href="{{ route('quotes.index') }}" class="block text-gray-700 hover:text-green-700">Quote Requests</a>
            <a href="{{ route('cart.view') }}" class="block text-gray-700 hover:text-green-700">🛒 Cart</a>
            @auth
            @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="block text-purple-700">Admin Panel</a>
            @elseif(Auth::user()->isVendor())
            <a href="{{ route('vendor.dashboard') }}" class="block text-blue-700">Vendor Dashboard</a>
            @endif
            <a href="{{ route('profile.show') }}" class="block text-gray-700 font-bold">👤 My Profile</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block text-gray-700">Login</a>
            <a href="{{ route('register') }}" class="block text-green-700 font-semibold">Become a Vendor</a>
            @endauth
        </div>
    </header>

    <!-- ================= CONTENT ================= -->
    <main>
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="relative bg-green-950 text-white py-16 mt-16 overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/footer-bg.jpg') }}" alt="Footer Background" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-t from-green-950 via-green-950/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-12 relative z-10">
            <div>
                <h3 class="font-black text-2xl mb-6 flex items-center gap-2">
                    <span class="text-3xl">🌿</span> LandScapeHub
                </h3>
                <p class="text-sm text-green-100 leading-relaxed italic">
                    Kenya's trusted landscaping marketplace connecting homeowners with professional landscapers and quality products. Transforming gardens into sanctuaries.
                </p>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-green-400 mb-6">Quick Links</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('products') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🌱</span> Shop Products</a></li>
                    <li><a href="{{ route('services') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🏗️</span> Services</a></li>
                    <li><a href="{{ route('register') }}" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🤝</span> Become Vendor</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-green-400 mb-6">Support</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="text-green-100 hover:text-white transition">Help Center</a></li>
                    <li><a href="#" class="text-green-100 hover:text-white transition">Contact Us</a></li>
                    <li><a href="#" class="text-green-100 hover:text-white transition">Terms & Conditions</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-black uppercase tracking-widest text-xs text-green-400 mb-6">Connect With Us</h4>
                <div class="flex space-x-4 mb-6">
                    <a href="#" class="w-10 h-10 rounded-full bg-green-800 flex items-center justify-center hover:bg-green-700 transition text-xl">📘</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-green-800 flex items-center justify-center hover:bg-green-700 transition text-xl">📸</a>
                    <a href="#" class="w-10 h-10 rounded-full bg-green-800 flex items-center justify-center hover:bg-green-700 transition text-xl">🐦</a>
                </div>
                <p class="text-xs text-green-300 italic">Follow our journey for daily gardening inspiration.</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 mt-16 pt-8 border-t border-green-800 text-center relative z-10">
            <p class="text-sm text-green-400">© 2026 LandScapeHub. Built with ❤️ for Kenyan Homeowners.</p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>