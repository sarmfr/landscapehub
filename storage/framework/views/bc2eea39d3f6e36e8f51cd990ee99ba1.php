

<?php $__env->startSection('title', 'My Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold mb-1">My Products</h1>
        <a href="<?php echo e(route('vendor.dashboard')); ?>" class="text-green-600 hover:text-green-800 text-sm">← Back to Dashboard</a>
    </div>
    <?php if($vendor->approval_status === 'approved'): ?>
    <a href="<?php echo e(route('vendor.products.create')); ?>" class="bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition">
        + Add Product
    </a>
    <?php endif; ?>
</div>

<?php if($vendor->approval_status !== 'approved'): ?>
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
    <p class="font-bold">Approval Required</p>
    <p>Your vendor profile must be approved before you can add products.</p>
</div>
<?php endif; ?>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-4 text-left font-semibold">Product</th>
                <th class="px-6 py-4 text-left font-semibold">Category</th>
                <th class="px-6 py-4 text-left font-semibold">Price</th>
                <th class="px-6 py-4 text-left font-semibold">Stock</th>
                <th class="px-6 py-4 text-left font-semibold">Status</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium"><?php echo e($product->name); ?></td>
                <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($product->category->name ?? '—'); ?></td>
                <td class="px-6 py-4 text-green-700 font-semibold">KES <?php echo e(number_format($product->price, 2)); ?></td>
                <td class="px-6 py-4">
                    <span class="<?php echo e($product->stock <= 5 ? 'text-red-600' : 'text-gray-700'); ?>"><?php echo e($product->stock); ?></span>
                </td>
                <td class="px-6 py-4">
                    <?php if($product->status === 'active'): ?>
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Active</span>
                    <?php else: ?>
                    <span class="inline-block bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-semibold">Inactive</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="<?php echo e(route('vendor.products.edit', $product)); ?>" class="text-green-600 hover:text-green-800 font-semibold text-sm">Edit</a>
                    <form action="<?php echo e(route('vendor.products.destroy', $product)); ?>" method="POST"
                        onsubmit="return confirm('Delete this product?');" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                    No products yet.
                    <?php if($vendor->approval_status === 'approved'): ?>
                    <a href="<?php echo e(route('vendor.products.create')); ?>" class="text-green-600 hover:underline ml-1">Add your first product →</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($products->hasPages()): ?>
<div class="mt-6"><?php echo e($products->withQueryString()->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/vendor/products/index.blade.php ENDPATH**/ ?>