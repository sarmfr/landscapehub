

<?php $__env->startSection('title', 'LandScapeHub - Kenya\'s #1 Landscaping Marketplace'); ?>

<?php $__env->startSection('content'); ?>
<!-- ================= HERO SECTION ================= -->
<section class="relative bg-green-900 text-white py-32 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/hero-bg.png')); ?>" alt="Beautiful Landscaping" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg">
            Kenya's #1 Landscaping Marketplace
        </h1>
        <p class="text-xl md:text-2xl mb-10 text-gray-100 max-w-3xl mx-auto drop-shadow-md">
            Find professional landscapers or shop quality garden products near you.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="<?php echo e(route('services')); ?>" class="bg-white text-green-900 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl transform hover:-translate-y-1">
                🚜 Browse Services
            </a>
            <a href="<?php echo e(route('products')); ?>" class="bg-green-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-xl transform hover:-translate-y-1">
                🌱 Shop Products
            </a>
        </div>
    </div>
</section>

<!-- ================= POPULAR CATEGORIES ================= -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-12 text-center text-green-900">Popular Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Category 1: Plants -->
            <a href="<?php echo e(route('products')); ?>?category=plants" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="<?php echo e(asset('images/categories/plants.png')); ?>" alt="Plants" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl mb-4 transform transition-transform group-hover:scale-125">🌱</span>
                    <h3 class="text-xl font-bold text-white mb-2">Plants & Flowers</h3>
                    <p class="text-white text-sm opacity-90">Enhance your garden with vibrant life.</p>
                </div>
            </a>

            <!-- Category 2: Tools -->
            <a href="<?php echo e(route('products')); ?>?category=tools" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="<?php echo e(asset('images/categories/tools.png')); ?>" alt="Garden Tools" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl mb-4 transform transition-transform group-hover:scale-125">🛠</span>
                    <h3 class="text-xl font-bold text-white mb-2">Garden Tools</h3>
                    <p class="text-white text-sm opacity-90">The right tools for every garden task.</p>
                </div>
            </a>

            <!-- Category 3: Irrigation -->
            <a href="<?php echo e(route('products')); ?>?category=irrigation" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="<?php echo e(asset('images/categories/irrigation.png')); ?>" alt="Irrigation" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl mb-4 transform transition-transform group-hover:scale-125">💧</span>
                    <h3 class="text-xl font-bold text-white mb-2">Irrigation</h3>
                    <p class="text-white text-sm opacity-90">Keep your landscape lush and watered.</p>
                </div>
            </a>

            <!-- Category 4: Services -->
            <a href="<?php echo e(route('services')); ?>" class="group relative block h-64 overflow-hidden rounded-2xl shadow-lg transition-all hover:shadow-2xl hover:-translate-y-2">
                <img src="<?php echo e(asset('images/vendor-bg.png')); ?>" alt="Landscaping Services" class="absolute inset-0 h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-black opacity-60 transition-opacity group-hover:opacity-50"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6">
                    <span class="text-4xl mb-4 transform transition-transform group-hover:scale-125">🌳</span>
                    <h3 class="text-xl font-bold text-white mb-2">Landscaping Services</h3>
                    <p class="text-white text-sm opacity-90">Professional design and maintenance.</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ================= FEATURED PRODUCTS ================= -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Trending Products</h2>
            <a href="<?php echo e(route('products')); ?>" class="text-green-700 hover:underline">View All</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-sm border p-4 hover:shadow-lg transition group">
                <div class="h-48 bg-gray-200 rounded-lg mb-4 overflow-hidden relative">
                    <?php if($product->getPrimaryImage()): ?>
                    <img src="<?php echo e($product->getPrimaryImage()); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-4xl">🌿</div>
                    <?php endif; ?>
                </div>
                <h3 class="font-bold text-gray-900"><?php echo e($product->name); ?></h3>
                <p class="text-gray-500 text-sm mb-2">by <?php echo e($product->vendor->business_name); ?></p>
                <div class="flex justify-between items-center mt-3">
                    <p class="text-green-800 font-black">KES <?php echo e(number_format($product->price)); ?></p>
                    <?php if($product->vendor->approval_status !== 'approved'): ?>
                    <span class="text-xs text-red-600 font-bold bg-red-50 px-2 py-1 rounded">Suspended</span>
                    <?php else: ?>
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <button type="submit" class="bg-green-100 text-green-800 p-2 rounded-lg hover:bg-green-700 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="col-span-4 text-center text-gray-500 py-12">No products available yet</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= FEATURED SERVICES ================= -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-center mb-12 text-center md:text-left flex-col md:row">
            <h2 class="text-3xl font-bold text-green-900 mb-4 md:mb-0">Popular Services</h2>
            <a href="<?php echo e(route('services')); ?>" class="text-green-700 font-bold hover:underline">View All Services →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__empty_1 = true; $__currentLoopData = $popularServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition group">
                <div class="h-56 bg-gray-300 relative overflow-hidden">
                    <?php if($service->getImageUrl()): ?>
                    <img src="<?php echo e($service->getImageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-4xl">🏗</div>
                    <?php endif; ?>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-800 shadow-sm uppercase">
                            <?php echo e($service->pricing_type); ?>

                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-900 mb-2"><?php echo e($service->name); ?></h3>
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <span class="mr-2">🏪</span>
                        <?php echo e($service->vendor->business_name); ?>

                    </div>

                    <div class="flex items-center justify-between border-t pt-4">
                        <div>
                            <?php if($service->pricing_type === 'fixed'): ?>
                            <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Starting from</p>
                            <p class="text-green-800 font-black text-xl">KES <?php echo e(number_format($service->price)); ?></p>
                            <?php else: ?>
                            <p class="text-green-800 font-bold">Custom Quote</p>
                            <?php endif; ?>
                        </div>
                        <?php if($service->vendor->approval_status !== 'approved'): ?>
                        <span class="text-xs text-red-600 font-bold bg-red-50 px-3 py-2 rounded-lg">Suspended</span>
                        <?php else: ?>
                        <a href="<?php echo e(route('services.show', $service->slug)); ?>" class="bg-green-700 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-800 transition">
                            Book Now
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="col-span-3 text-center text-gray-500 py-12">No services available yet</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-12">How It Works</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <div class="text-4xl mb-4">🔍</div>
                <h3 class="font-semibold mb-2">Browse</h3>
                <p class="text-gray-600">Search for products or professional landscapers in your area.</p>
            </div>
            <div>
                <div class="text-4xl mb-4">🛒</div>
                <h3 class="font-semibold mb-2">Order / Book</h3>
                <p class="text-gray-600">Add to cart or book services easily with just a few clicks.</p>
            </div>
            <div>
                <div class="text-4xl mb-4">🌿</div>
                <h3 class="font-semibold mb-2">Enjoy Results</h3>
                <p class="text-gray-600">Receive quality products or expert landscaping services.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="relative bg-green-800 text-white py-20 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="<?php echo e(asset('images/vendor-bg.png')); ?>" alt="Landscaping Professional" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-green-900 opacity-70"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 drop-shadow-md">Want to become a vendor?</h2>
        <p class="text-lg mb-8 text-green-50 max-w-2xl mx-auto drop-shadow-sm">Join Kenya's leading landscaping marketplace and grow your business by reaching thousands of customers.</p>
        <a href="<?php echo e(route('register')); ?>" class="bg-white text-green-800 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition shadow-xl inline-block transform hover:-translate-y-1">
            🚀 Join as Vendor Today
        </a>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/home.blade.php ENDPATH**/ ?>