<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'LandScapeHub - Kenya\'s #1 Landscaping Marketplace'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="bg-gray-100 font-sans">

    <!-- ================= NAVBAR ================= -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <!-- Logo -->
            <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-green-800 flex-shrink-0">
                🌿 LandScapeHub
            </a>

            <!-- Search Bar -->
            <div class="flex-1 mx-6 hidden md:block">
                <form action="<?php echo e(route('products')); ?>" method="GET">
                    <input type="text" name="search" placeholder="Search products or services..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
                </form>
            </div>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center space-x-4 text-sm font-medium">
                <a href="<?php echo e(route('products')); ?>" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition <?php echo e(request()->routeIs('products*') ? 'text-green-700 font-semibold' : ''); ?>">Products</a>
                <a href="<?php echo e(route('services')); ?>" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition <?php echo e(request()->routeIs('services*') ? 'text-green-700 font-semibold' : ''); ?>">Services</a>
                <a href="<?php echo e(route('quotes.index')); ?>" class="text-gray-700 hover:text-green-700 px-2 py-1 rounded transition <?php echo e(request()->routeIs('quotes*') ? 'text-green-700 font-semibold' : ''); ?>">Requests</a>

                <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->isAdmin()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-purple-700 hover:text-purple-900 px-2 py-1 rounded transition">Admin</a>
                <?php elseif(Auth::user()->isVendor()): ?>
                <a href="<?php echo e(route('vendor.dashboard')); ?>" class="text-blue-700 hover:text-blue-900 px-2 py-1 rounded transition">Vendor Dashboard</a>
                <?php endif; ?>
                <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center gap-2 group border-l pl-4">
                    <span class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-black group-hover:bg-green-700 group-hover:text-white transition"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                    <span class="text-gray-700 font-bold group-hover:text-green-700 transition">My Profile</span>
                </a>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-red-600 hover:text-red-800 transition">Logout</button>
                </form>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="text-gray-700 hover:text-green-700 transition">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">
                    Become Vendor
                </a>
                <?php endif; ?>

                <!-- Cart -->
                <a href="<?php echo e(route('cart.view')); ?>" class="relative text-2xl ml-2">
                    🛒
                    <?php if(count(session()->get('cart', [])) > 0): ?>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                        <?php echo e(count(session()->get('cart', []))); ?>

                    </span>
                    <?php endif; ?>
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
            <form action="<?php echo e(route('products')); ?>" method="GET" class="mb-3">
                <input type="text" name="search" placeholder="Search..." class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-green-600">
            </form>
            <a href="<?php echo e(route('products')); ?>" class="block text-gray-700 hover:text-green-700">Products</a>
            <a href="<?php echo e(route('services')); ?>" class="block text-gray-700 hover:text-green-700">Services</a>
            <a href="<?php echo e(route('quotes.index')); ?>" class="block text-gray-700 hover:text-green-700">Quote Requests</a>
            <a href="<?php echo e(route('cart.view')); ?>" class="block text-gray-700 hover:text-green-700">🛒 Cart</a>
            <?php if(auth()->guard()->check()): ?>
            <?php if(Auth::user()->isAdmin()): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block text-purple-700">Admin Panel</a>
            <?php elseif(Auth::user()->isVendor()): ?>
            <a href="<?php echo e(route('vendor.dashboard')); ?>" class="block text-blue-700">Vendor Dashboard</a>
            <?php endif; ?>
            <a href="<?php echo e(route('profile.show')); ?>" class="block text-gray-700 font-bold">👤 My Profile</a>
            <form action="<?php echo e(route('logout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
            </form>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="block text-gray-700">Login</a>
            <a href="<?php echo e(route('register')); ?>" class="block text-green-700 font-semibold">Become a Vendor</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- ================= CONTENT ================= -->
    <main>
        <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
        <div class="max-w-7xl mx-auto px-6 pt-4">
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="relative bg-green-950 text-white py-16 mt-16 overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="<?php echo e(asset('images/footer-bg.jpg')); ?>" alt="Footer Background" class="w-full h-full object-cover opacity-20">
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
                    <li><a href="<?php echo e(route('products')); ?>" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🌱</span> Shop Products</a></li>
                    <li><a href="<?php echo e(route('services')); ?>" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🏗️</span> Services</a></li>
                    <li><a href="<?php echo e(route('register')); ?>" class="text-green-100 hover:text-white transition flex items-center gap-2"><span>🤝</span> Become Vendor</a></li>
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

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/layouts/app.blade.php ENDPATH**/ ?>