

<?php $__env->startSection('title', 'Manage Products'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold">Product Moderation</h1>
    <p class="text-gray-600">Review and moderate all marketplace products</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Product</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Vendor</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Category</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Price</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Status</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900"><?php echo e($product->name); ?></div>
                    <div class="text-xs text-gray-500">SKU: #<?php echo e($product->id); ?></div>
                </td>
                <td class="px-6 py-4 text-sm">
                    <a href="<?php echo e(route('admin.vendors.show', $product->vendor)); ?>" class="text-purple-600 hover:underline">
                        <?php echo e($product->vendor->business_name); ?>

                    </a>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    <?php echo e($product->category->name); ?>

                </td>
                <td class="px-6 py-4 font-medium">KES <?php echo e(number_format($product->price)); ?></td>
                <td class="px-6 py-4">
                    <form action="<?php echo e(route('admin.products.status', $product)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <select name="status" onchange="this.form.submit()" class="text-xs border rounded px-2 py-1 <?php echo e($product->status === 'active' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'); ?>">
                            <option value="active" <?php echo e($product->status === 'active' ? 'selected' : ''); ?>>Active</option>
                            <option value="inactive" <?php echo e($product->status === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            <option value="suspended" <?php echo e($product->status === 'suspended' ? 'selected' : ''); ?>>Suspended</option>
                        </select>
                    </form>
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" target="_blank" class="text-blue-600 hover:text-blue-900 font-medium text-sm">View</a>
                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">No products found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="px-6 py-4 border-t">
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/products/index.blade.php ENDPATH**/ ?>