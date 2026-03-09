

<?php $__env->startSection('title', $user->name . ' - User Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-xl">
                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

            </div>
            <div>
                <h1 class="text-3xl font-bold"><?php echo e($user->name); ?></h1>
                <p class="text-gray-500 text-sm">Joined <?php echo e($user->created_at->format('F d, Y')); ?></p>
            </div>
        </div>
    </div>
    <div class="flex gap-4">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-200 transition">← Back to Users</a>
        <?php if(!$user->isAdmin()): ?>
        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Delete this user?');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition">Delete User</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Account Info Panel -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Account Information</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium"><?php echo e($user->email); ?>

                        <?php if($user->is_verified): ?> <span class="text-green-600 text-xs ml-1">✓ Verified</span> <?php endif; ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium"><?php echo e($user->phone ?? 'Not provided'); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Role</p>
                    <?php if($user->isAdmin()): ?>
                    <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">Admin</span>
                    <?php elseif($user->isVendor()): ?>
                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Vendor</span>
                    <?php else: ?>
                    <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-semibold">Customer</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if($user->isVendor() && $user->vendor): ?>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Vendor Details</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-500">Business Name</p>
                    <p class="font-medium"><?php echo e($user->vendor->business_name); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <?php if($user->vendor->approval_status === 'approved'): ?>
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                    <?php elseif($user->vendor->approval_status === 'pending'): ?>
                    <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Pending</span>
                    <?php else: ?>
                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold capitalize"><?php echo e($user->vendor->approval_status); ?></span>
                    <?php endif; ?>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Commission Rate</p>
                    <p class="font-medium"><?php echo e($user->vendor->commission_rate); ?>%</p>
                </div>
                <a href="<?php echo e(route('admin.vendors.show', $user->vendor)); ?>" class="inline-block mt-2 text-green-600 hover:text-green-800 font-medium text-sm">View Full Vendor Profile →</a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Activity Panel -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold">Recent Orders</h2>
                <span class="text-sm text-gray-500"><?php echo e($user->orders->count()); ?> total</span>
            </div>
            <?php if($user->orders->count() > 0): ?>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 text-xs uppercase">
                        <th class="pb-2">Order</th>
                        <th class="pb-2">Date</th>
                        <th class="pb-2">Amount</th>
                        <th class="pb-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $user->orders->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="py-2 text-green-600 font-medium">#<?php echo e(str_pad($order->id, 5, '0', STR_PAD_LEFT)); ?></td>
                        <td class="py-2 text-gray-500"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                        <td class="py-2">KES <?php echo e(number_format($order->total_amount, 2)); ?></td>
                        <td class="py-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold <?php echo e($order->status === 'delivered' ? 'bg-green-100 text-green-800' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="text-gray-500 text-center py-4">No orders placed yet.</p>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-bold">Recent Reviews</h2>
                <span class="text-sm text-gray-500"><?php echo e($user->reviews->count()); ?> total</span>
            </div>
            <?php if($user->reviews->count() > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $user->reviews->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 p-4 rounded-lg text-sm">
                    <div class="flex justify-between items-start mb-2">
                        <div class="text-yellow-400"><?php for($i = 0; $i < 5; $i++): ?><?php echo e($i < $review->rating ? '★' : '☆'); ?><?php endfor; ?></div>
                                <span class="text-gray-400 text-xs"><?php echo e($review->created_at->diffForHumans()); ?></span>
                        </div>
                        <p class="text-gray-700">"<?php echo e(\Illuminate\Support\Str::limit($review->comment, 150)); ?>"</p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-gray-500 text-center py-4">No reviews yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/users/show.blade.php ENDPATH**/ ?>