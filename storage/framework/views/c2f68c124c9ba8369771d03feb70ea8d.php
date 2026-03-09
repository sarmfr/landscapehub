

<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold">Vendor Profile</h1>
            <p class="text-gray-600">Publicly visible business information</p>
        </div>
        <a href="<?php echo e(route('vendor.profile.edit')); ?>" class="bg-green-700 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-800 transition">
            Edit Profile
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar / Logo -->
        <div class="col-span-1">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <?php if($vendor->profile_image): ?>
                <img src="<?php echo e(asset('storage/' . $vendor->profile_image)); ?>" alt="<?php echo e($vendor->business_name); ?>" class="w-48 h-48 mx-auto rounded-lg object-cover mb-4">
                <?php else: ?>
                <div class="w-48 h-48 mx-auto rounded-lg bg-gray-100 flex items-center justify-center text-5xl mb-4">
                    🏪
                </div>
                <?php endif; ?>
                <h2 class="text-xl font-bold"><?php echo e($vendor->business_name); ?></h2>
                <p class="text-sm text-gray-500 mt-1">Vendor since <?php echo e($vendor->created_at->format('M Y')); ?></p>
                <div class="mt-4">
                    <?php if($vendor->approval_status === 'approved'): ?>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Approved Vendor</span>
                    <?php else: ?>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider"><?php echo e($vendor->approval_status); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="font-bold mb-4 border-b pb-2">Contact Info</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Phone</p>
                        <p class="font-medium"><?php echo e($vendor->business_phone); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Address</p>
                        <p class="font-medium"><?php echo e($vendor->business_address); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Location</p>
                        <p class="font-medium"><?php echo e($vendor->location); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-8">
                <h3 class="text-xl font-bold mb-4">About the Business</h3>
                <div class="prose prose-sm text-gray-700 max-w-none">
                    <?php echo nl2br(e($vendor->description)); ?>

                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-8">
                <h3 class="text-xl font-bold mb-4">Recent Statistics</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <p class="text-gray-500 text-sm">Products</p>
                        <p class="text-2xl font-bold"><?php echo e($vendor->products_count ?? $vendor->products->count()); ?></p>
                    </div>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <p class="text-gray-500 text-sm">Services</p>
                        <p class="text-2xl font-bold"><?php echo e($vendor->services_count ?? $vendor->services->count()); ?></p>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="<?php echo e(route('vendor.dashboard')); ?>" class="text-green-700 font-semibold hover:underline">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vendor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/vendor/profile/show.blade.php ENDPATH**/ ?>