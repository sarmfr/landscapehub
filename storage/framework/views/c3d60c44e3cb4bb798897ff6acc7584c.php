

<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <!-- Breadcrumb -->
    <div class="mb-8 text-gray-600 text-sm">
        <a href="<?php echo e(route('home')); ?>" class="hover:text-green-700">Home</a> /
        <a href="<?php echo e(route('products')); ?>" class="hover:text-green-700">Products</a> /
        <span><?php echo e($product->name); ?></span>
    </div>

    <!-- Product Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 bg-white p-8 rounded-lg shadow">
        <!-- Images -->
        <div>
            <div class="h-96 bg-gray-300 rounded-lg mb-4 flex items-center justify-center">
                <span class="text-6xl">🌿</span>
            </div>
            <?php if($product->images->count() > 0): ?>
            <div class="grid grid-cols-4 gap-2">
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="h-20 bg-gray-200 rounded cursor-pointer hover:opacity-75"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2"><?php echo e($product->name); ?></h1>
            <div class="mb-4">
                <p class="text-gray-600">by <a href="#" class="text-green-700 font-semibold hover:underline"><?php echo e($product->vendor->business_name); ?></a></p>
            </div>
            <div class="mb-6 flex items-center">
                <div class="text-yellow-400 text-lg">
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <?php if($i < floor($product->rating)): ?> ⭐ <?php else: ?> ☆ <?php endif; ?>
                        <?php endfor; ?>
                </div>
                <span class="ml-2 text-gray-600">(<?php echo e($product->reviews->count()); ?> reviews)</span>
            </div>
            <div class="mb-6">
                <div class="text-4xl font-bold text-green-700 mb-2">KES <?php echo e(number_format($product->price)); ?></div>
            </div>
            <div class="mb-6">
                <?php if($product->stock > 0): ?>
                <p class="text-green-600 font-semibold">✓ In Stock (<?php echo e($product->stock); ?> available)</p>
                <?php else: ?>
                <p class="text-red-600 font-semibold">✗ Out of Stock</p>
                <?php endif; ?>
            </div>
            <div class="mb-8">
                <h3 class="font-semibold text-lg mb-2">Description</h3>
                <p class="text-gray-700 leading-relaxed"><?php echo e($product->description); ?></p>
            </div>
            <?php if($product->stock > 0): ?>
            <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mb-6">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                <div class="flex gap-4 items-center">
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo e($product->stock); ?>"
                        class="w-16 px-3 py-2 border border-gray-300 rounded-lg">
                    <button type="submit" class="flex-1 bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                        Add to Cart
                    </button>
                </div>
            </form>
            <?php else: ?>
            <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed mb-6">Out of Stock</button>
            <?php endif; ?>
            <div class="border-t pt-6">
                <p class="text-gray-600 mb-3">Share this product:</p>
                <div class="flex gap-3">
                    <button class="text-blue-600 hover:text-blue-800">📘 Facebook</button>
                    <button class="text-blue-400 hover:text-blue-600">🐦 Twitter</button>
                    <button class="text-green-600 hover:text-green-800">💬 WhatsApp</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if($relatedProducts->count() > 0): ?>
    <div class="mt-16">
        <h2 class="text-2xl font-bold mb-8">Related Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
                <div class="h-40 bg-gray-200 rounded-lg mb-4 flex items-center justify-center"><span class="text-4xl">🌿</span></div>
                <h3 class="font-semibold mb-1"><?php echo e($related->name); ?></h3>
                <p class="text-gray-600 text-sm mb-2"><?php echo e($related->vendor->business_name); ?></p>
                <p class="text-green-700 font-bold">KES <?php echo e(number_format($related->price)); ?></p>
                <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mt-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($related->id); ?>">
                    <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 text-sm transition">Add to Cart</button>
                </form>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/products/show.blade.php ENDPATH**/ ?>