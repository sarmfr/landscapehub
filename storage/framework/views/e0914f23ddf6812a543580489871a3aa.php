

<?php $__env->startSection('title', 'Manage Categories'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold">Categories</h1>
        <p class="text-gray-600">Manage product and service categories</p>
    </div>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-800 transition">
        + Add New Category
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Icon</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Name</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Type</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700">Items</th>
                <th class="px-6 py-4 font-semibold text-sm text-gray-700 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-2xl"><?php echo e($category->icon ?: '📁'); ?></td>
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900"><?php echo e($category->name); ?></div>
                    <div class="text-xs text-gray-500"><?php echo e($category->slug); ?></div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded text-xs font-bold uppercase <?php echo e($category->type === 'product' ? 'bg-blue-100 text-blue-800' : ($category->type === 'service' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800')); ?>">
                        <?php echo e($category->type); ?>

                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    <?php echo e($category->products_count); ?> products, <?php echo e($category->services_count); ?> services
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="text-blue-600 hover:text-blue-900 font-medium">Edit</a>
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No categories found.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>