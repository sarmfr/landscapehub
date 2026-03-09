

<?php $__env->startSection('title', 'Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Our Products</h1>
        <p class="text-gray-600">Browse our wide selection of landscaping products</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h3 class="font-bold text-lg mb-4">Filters</h3>
            <form action="<?php echo e(route('products')); ?>" method="GET">
                <div class="mb-6">
                    <h4 class="font-semibold mb-3">Category</h4>
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
                    <h4 class="font-semibold mb-3">Price Range</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="price_ranges[]" value="under_500" class="mr-2"
                                <?php echo e(in_array('under_500', request('price_ranges', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">Under 500</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="price_ranges[]" value="500_1000" class="mr-2"
                                <?php echo e(in_array('500_1000', request('price_ranges', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">500 - 1,000</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="price_ranges[]" value="1000_5000" class="mr-2"
                                <?php echo e(in_array('1000_5000', request('price_ranges', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">1,000 - 5,000</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="price_ranges[]" value="above_5000" class="mr-2"
                                <?php echo e(in_array('above_5000', request('price_ranges', [])) ? 'checked' : ''); ?>>
                            <span class="text-gray-700">Above 5,000</span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 transition">
                    Apply Filters
                </button>
                <a href="<?php echo e(route('products')); ?>" class="block text-center text-sm text-gray-500 mt-2 hover:underline">
                    Clear All
                </a>
            </form>
        </div>

        <!-- Products -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
                    <div class="h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                        <span class="text-4xl">🌿</span>
                    </div>
                    <h3 class="font-semibold mb-1"><?php echo e($product->name); ?></h3>
                    <p class="text-gray-600 text-sm mb-2"><?php echo e($product->vendor->business_name); ?></p>
                    <p class="text-green-700 font-bold">KES <?php echo e(number_format($product->price)); ?></p>
                    <p class="text-gray-600 text-xs mb-4">Stock: <?php echo e($product->stock); ?></p>
                    <?php if($product->vendor->approval_status !== 'approved'): ?>
                    <button disabled class="w-full bg-red-100 text-red-700 py-2 rounded-lg font-semibold cursor-not-allowed mt-4">
                        Vendor Suspended
                    </button>
                    <?php else: ?>
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mt-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 transition">
                            Add to Cart
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">No products found</p>
                </div>
                <?php endif; ?>
            </div>
            <div class="mt-8 flex justify-center">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/products/index.blade.php ENDPATH**/ ?>