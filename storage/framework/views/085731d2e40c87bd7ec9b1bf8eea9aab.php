

<?php $__env->startSection('title', 'Add Category'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-purple-700 hover:underline">← Back to Categories</a>
        <h1 class="text-3xl font-bold mt-2">Add New Category</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Category Name</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600"
                    placeholder="e.g. Indoor Plants">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Icon (Emoji or FontAwesome class)</label>
                <input type="text" name="icon" value="<?php echo e(old('icon')); ?>"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600"
                    placeholder="e.g. 🌱 or fa-seedling">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Type</label>
                <select name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600">
                    <option value="product" <?php echo e(old('type') === 'product' ? 'selected' : ''); ?>>Product Only</option>
                    <option value="service" <?php echo e(old('type') === 'service' ? 'selected' : ''); ?>>Service Only</option>
                    <option value="both" <?php echo e(old('type') === 'both' ? 'selected' : ''); ?>>Both</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-purple-600"
                    placeholder="Brief description of the category..."><?php echo e(old('description')); ?></textarea>
            </div>

            <button type="submit" class="w-full bg-purple-700 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                Create Category
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>