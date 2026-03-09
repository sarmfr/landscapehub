

<?php $__env->startSection('title', $service->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <div class="mb-8 text-gray-600 text-sm">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-green-700">Home</a> /
        <a href="<?php echo e(route('services')); ?>" class="hover:text-green-700">Services</a> /
        <span><?php echo e($service->name); ?></span>
    </div>

    <!-- Service Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Image -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border overflow-hidden">
            <div class="h-96 bg-gray-100 rounded-xl overflow-hidden">
                <?php if($service->image_path): ?>
                <img src="<?php echo e($service->image_path); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-6xl">🏗</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Details -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border">
            <h1 class="text-3xl font-bold mb-2 text-gray-900"><?php echo e($service->name); ?></h1>
            <div class="mb-6">
                <p class="text-gray-600 flex items-center">
                    <span class="mr-2">🏪</span>
                    by <a href="#" class="text-green-700 font-bold hover:underline ml-1"><?php echo e($service->vendor->business_name); ?></a>
                </p>
                <p class="text-gray-500 text-sm mt-1">📍 Located in <?php echo e($service->vendor->location); ?></p>
            </div>
            <div class="mb-8 flex items-center">
                <div class="text-yellow-400 text-lg">
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <?php if($i < floor($service->rating)): ?> ⭐ <?php else: ?> ☆ <?php endif; ?>
                        <?php endfor; ?>
                </div>
                <span class="ml-2 text-gray-500 font-medium">(<?php echo e($service->reviews->count()); ?> reviews)</span>
            </div>
            <div class="mb-8">
                <?php if($service->pricing_type === 'fixed'): ?>
                <p class="text-sm text-gray-500 uppercase font-black tracking-widest mb-1">Pricing Starts From</p>
                <div class="text-4xl font-black text-green-800">KES <?php echo e(number_format($service->price)); ?></div>
                <?php else: ?>
                <div class="bg-green-50 border border-green-100 text-green-800 p-6 rounded-2xl">
                    <h3 class="font-bold mb-1">Custom Quote Service</h3>
                    <p class="text-sm opacity-90">Book today to receive a personalized quote based on your specific requirements.</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="mb-8">
                <h3 class="font-bold text-gray-900 mb-2">Service Description</h3>
                <p class="text-gray-600 leading-relaxed"><?php echo e($service->description); ?></p>
            </div>
            <div class="mb-8 border-t pt-8">
                <h3 class="font-bold text-gray-900 mb-4">Service Provider Details</h3>
                <div class="space-y-3">
                    <p class="text-gray-600 text-sm leading-relaxed"><?php echo e($service->vendor->description); ?></p>
                    <div class="flex items-center text-gray-700">
                        <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-700">📞</span>
                        <a href="tel:<?php echo e($service->vendor->business_phone); ?>" class="hover:text-green-700 font-mediumTransition transition">
                            <?php echo e($service->vendor->business_phone ?? 'Contact via platform'); ?>

                        </a>
                    </div>
                </div>
            </div>
            <?php if($service->vendor->approval_status !== 'approved'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <span class="mr-2 text-xl">🚫</span>
                <span>This vendor is currently suspended. Bookings are temporarily disabled.</span>
            </div>
            <button disabled class="block text-center w-full bg-gray-400 text-white py-4 rounded-xl font-bold text-lg cursor-not-allowed">
                Service Unavailable
            </button>
            <?php else: ?>
            <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('bookings.create', $service->id)); ?>" class="block text-center w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                Book This Service Now
            </a>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="block text-center w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg">
                Login to Book Service
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-12 bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
        <?php if($service->reviews->count() > 0): ?>
        <div class="space-y-6">
            <?php $__currentLoopData = $service->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-b pb-6">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold"><?php echo e($review->user->name); ?></h4>
                    <span class="text-yellow-400"><?php for($i = 0; $i < $review->rating; $i++): ?>⭐<?php endfor; ?></span>
                </div>
                <p class="text-gray-500 text-sm mb-2"><?php echo e($review->created_at->format('M d, Y')); ?></p>
                <p class="text-gray-700"><?php echo e($review->comment); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <p class="text-gray-600">No reviews yet. Be the first to review this service!</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/services/show.blade.php ENDPATH**/ ?>