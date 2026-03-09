

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold mb-2">User Management</h1>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-green-600 hover:text-green-800 text-sm">← Back to Dashboard</a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" class="flex gap-4 flex-wrap">
        <div class="flex-1 min-w-64">
            <input type="text" name="search" placeholder="Search by name or email..." value="<?php echo e(request('search')); ?>"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
        </div>
        <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
            <option value="">All Roles</option>
            <option value="customer" <?php echo e(request('role') === 'customer' ? 'selected' : ''); ?>>Customer</option>
            <option value="vendor" <?php echo e(request('role') === 'vendor' ? 'selected' : ''); ?>>Vendor</option>
            <option value="admin" <?php echo e(request('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg">Filter</button>
        <?php if(request()->hasAny(['search', 'role'])): ?>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-gray-600 hover:text-gray-900 py-2 px-4">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-4 text-left font-semibold">User</th>
                <th class="px-6 py-4 text-left font-semibold">Role</th>
                <th class="px-6 py-4 text-left font-semibold">Joined</th>
                <th class="px-6 py-4 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-lg flex-shrink-0">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                        <div>
                            <div class="font-medium text-gray-900"><?php echo e($user->name); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <?php if($user->isAdmin()): ?>
                    <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                    <?php elseif($user->isVendor()): ?>
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Vendor</span>
                    <?php else: ?>
                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Customer</span>
                    <?php endif; ?>
                    <?php if($user->is_verified): ?>
                    <span class="ml-1 text-green-600 text-xs">✓ Verified</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                <td class="px-6 py-4">
                    <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="text-green-600 hover:text-green-800 font-semibold text-sm mr-4">View</a>
                    <?php if(!$user->isAdmin()): ?>
                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline"
                        onsubmit="return confirm('Delete this user?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Delete</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">No users found matching your criteria.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if($users->hasPages()): ?>
<div class="mt-6"><?php echo e($users->withQueryString()->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/users/index.blade.php ENDPATH**/ ?>