

<?php $__env->startSection('title', 'Approve Vendor'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="text-green-600 hover:text-green-800 mb-4 inline-block">← Back to Vendor</a>
        <h1 class="text-3xl font-bold">Approve Vendor</h1>
    </div>

    <?php if($errors->any()): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <h3 class="text-red-800 font-bold mb-2">Please fix the following errors:</h3>
        <ul class="list-disc pl-5 text-red-700">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Vendor Summary -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-xl font-bold mb-4">Vendor Summary</h2>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-semibold text-gray-600">Business Name</label>
                    <p class="text-gray-900"><?php echo e($vendor->business_name); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Owner</label>
                    <p class="text-gray-900"><?php echo e($vendor->user->name); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Email</label>
                    <p class="text-gray-900"><?php echo e($vendor->user->email); ?></p>
                </div>
                <div><label class="block text-sm font-semibold text-gray-600">Location</label>
                    <p class="text-gray-900"><?php echo e($vendor->location); ?></p>
                </div>
                <div class="col-span-2"><label class="block text-sm font-semibold text-gray-600">Description</label>
                    <p class="text-gray-900"><?php echo e($vendor->description); ?></p>
                </div>
            </div>
        </div>

        <!-- Approval Form -->
        <form action="<?php echo e(route('admin.vendors.approve', $vendor)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div>
                <label for="commission_rate" class="block text-sm font-medium text-gray-700 mb-2">Commission Rate (%) <span class="text-red-600">*</span></label>
                <div class="flex items-center gap-4">
                    <input type="number" id="commission_rate" name="commission_rate" value="<?php echo e(old('commission_rate', 15)); ?>"
                        min="0" max="100" step="0.1" required
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <span class="text-gray-600">%</span>
                </div>
                <p class="text-gray-500 text-sm mt-2">Platform commission on each sale. Typical range: 10-20%</p>
                <?php $__errorArgs = ['commission_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Internal Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                    placeholder="Add any internal notes about this vendor..."><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-green-800 text-sm"><strong>Note:</strong> Approving this vendor will send them a notification email and allow them to start listing products and services.</p>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">Approve Vendor</button>
                <a href="<?php echo e(route('admin.vendors.show', $vendor)); ?>" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg text-center transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/admin/vendors/approve.blade.php ENDPATH**/ ?>