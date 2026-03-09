

<?php $__env->startSection('title', 'Services'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Our Services</h1>
        <p class="text-gray-600">Find professional landscaping services tailored to your needs</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h3 class="font-bold text-lg mb-4">Filters</h3>
            <form action="<?php echo e(route('services')); ?>" method="GET">
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Service Category</h4>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="flex items-center">
                            <input type="checkbox" name="categories[]" value="<?php echo e($category->id); ?>" class="mr-2"
                                <?php echo e(in_array($category->id, request('categories', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700"><?php echo e($category->name); ?></span>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Pricing</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="pricing_types[]" value="fixed" class="mr-2"
                                <?php echo e(in_array('fixed', request('pricing_types', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">Fixed Price</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="pricing_types[]" value="quote" class="mr-2"
                                <?php echo e(in_array('quote', request('pricing_types', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">Custom Quote</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 transition">
                    Apply Filters
                </button>
                <a href="<?php echo e(route('services')); ?>" class="block text-center text-sm text-gray-500 mt-2 hover:underline">
                    Clear All
                </a>
            </form>
        </div>

        <!-- Services -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <div class="h-40 bg-gray-300 rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-4xl">🏗</span>
                    </div>
                    <h3 class="font-semibold text-lg mb-1"><?php echo e($service->name); ?></h3>
                    <p class="text-gray-600 text-sm mb-2">by <?php echo e($service->vendor->business_name); ?></p>
                    <?php if($service->pricing_type === 'fixed'): ?>
                    <p class="text-green-700 font-bold mb-4">Starting from KES <?php echo e(number_format($service->price)); ?></p>
                    <?php else: ?>
                    <p class="text-green-700 font-bold mb-4">Custom Quote</p>
                    <?php endif; ?>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e(Str::limit($service->description, 100)); ?></p>
                    <?php if($service->vendor->approval_status !== 'approved'): ?>
                    <button disabled class="block w-full text-center bg-red-100 text-red-700 px-4 py-2 rounded-lg font-semibold cursor-not-allowed">
                        Service Unavailable
                    </button>
                    <?php else: ?>
                    <a href="<?php echo e(route('services.show', $service->slug)); ?>"
                        class="block w-full text-center bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 transition">
                        View Details
                    </a>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-2 text-center py-12">
                    <p class="text-gray-500">No services found</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="mt-8 flex justify-center">
                <?php echo e($services->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/services/index.blade.php ENDPATH**/ ?>