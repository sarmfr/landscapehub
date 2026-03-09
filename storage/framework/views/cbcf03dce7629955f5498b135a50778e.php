

<?php $__env->startSection('title', 'Vendor Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <a href="<?php echo e(route('admin.vendors.index')); ?>" class="text-green-600 hover:text-green-800 mb-4 inline-block">← Back to Vendors</a>
    <h1 class="text-3xl font-bold">Vendor Details</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Main Info -->
    <div class="md:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Business Information</h2>
            <?php if($vendor->profile_image): ?>
            <div class="mb-6">
                <img src="<?php echo e(asset('storage/' . $vendor->profile_image)); ?>" alt="Profile" class="h-48 w-48 object-cover rounded-lg">
            </div>
            <?php endif; ?>
            <div class="space-y-4">
                <div><label class="block text-sm font-semibold text-gray-600">Business Name</label>
                    <p class="text-gray-900"><?php echo e($vendor->business_name); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Owner</label>
                    <p class="text-gray-900"><?php echo e($vendor->user->name); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Email</label>
                    <p class="text-gray-900"><?php echo e($vendor->user->email); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Phone</label>
                    <p class="text-gray-900"><?php echo e($vendor->business_phone); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Location</label>
                    <p class="text-gray-900"><?php echo e($vendor->location); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Business Address</label>
                    <p class="text-gray-900"><?php echo e($vendor->business_address); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Description</label>
                    <p class="text-gray-900"><?php echo e($vendor->description); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Statistics</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-600">Total Products</label>
                    <p class="text-3xl font-bold text-blue-600"><?php echo e($vendor->products()->count()); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Total Services</label>
                    <p class="text-3xl font-bold text-green-600"><?php echo e($vendor->services()->count()); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Total Bookings</label>
                    <p class="text-3xl font-bold text-purple-600"><?php echo e($vendor->bookings()->count()); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Average Rating</label>
                    <p class="text-3xl font-bold text-yellow-600"><?php echo e(round($vendor->getAverageRating(), 1)); ?>/5</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status & Actions -->
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Status</h2>
            <div class="mb-6">
                <?php if($vendor->approval_status === 'pending'): ?>
                <span class="inline-block bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-semibold">Pending Approval</span>
                <?php elseif($vendor->approval_status === 'approved'): ?>
                <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">Approved</span>
                <?php elseif($vendor->approval_status === 'rejected'): ?>
                <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">Rejected</span>
                <?php elseif($vendor->approval_status === 'suspended'): ?>
                <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">Suspended</span>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600">Commission Rate</label>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($vendor->commission_rate); ?>%</p>
            </div>
            <div class="text-sm text-gray-600">
                <p>Created: <?php echo e($vendor->created_at->format('M d, Y')); ?></p>
                <p>Updated: <?php echo e($vendor->updated_at->format('M d, Y')); ?></p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Actions</h2>
            <div class="space-y-2">
                <?php if($vendor->approval_status === 'pending'): ?>
                <a href="<?php echo e(route('admin.vendors.edit', $vendor)); ?>" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-center">Approve Vendor</a>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Reject Vendor</button>
                <?php elseif($vendor->approval_status === 'approved'): ?>
                <button onclick="document.getElementById('suspendModal').classList.remove('hidden')" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg">Suspend Vendor</button>
                <?php elseif($vendor->approval_status === 'suspended'): ?>
                <form action="<?php echo e(route('admin.vendors.reactivate', $vendor)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Reactivate Vendor</button>
                </form>
                <?php endif; ?>
                <?php if($vendor->approval_status !== 'pending'): ?>
                <form action="<?php echo e(route('admin.vendors.destroy', $vendor)); ?>" method="POST" onsubmit="return confirm('Are you sure?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Delete Vendor</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Reject Vendor</h2>
        <form action="<?php echo e(route('admin.vendors.reject', $vendor)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Reason for Rejection</label>
                <textarea name="rejection_reason" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Explain why you're rejecting this vendor..."></textarea>
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Reject</button>
            </div>
        </form>
    </div>
</div>

<!-- Suspend Modal -->
<div id="suspendModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-xl font-bold mb-4">Suspend Vendor</h2>
        <form action="<?php echo e(route('admin.vendors.suspend', $vendor)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Reason for Suspension</label>
                <textarea name="suspension_reason" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600" placeholder="Explain why you're suspending this vendor..."></textarea>
            </div>
            <div class="flex gap-4">
                <button type="button" onclick="document.getElementById('suspendModal').classList.add('hidden')" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg">Cancel</button>
                <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg">Suspend</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/vendors/show.blade.php ENDPATH**/ ?>