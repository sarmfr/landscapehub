

<?php $__env->startSection('title', 'Write a Review'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <?php if($type === 'product'): ?>
        <a href="<?php echo e(route('products.show', $item->slug)); ?>" class="text-green-700 hover:underline font-bold">← Back to Product</a>
        <?php else: ?>
        <a href="<?php echo e(route('services.show', $item->slug)); ?>" class="text-green-700 hover:underline font-bold">← Back to Service</a>
        <?php endif; ?>
        <h1 class="text-3xl font-black mt-2 text-gray-900">Share Your Experience</h1>
        <p class="text-gray-500 italic">Your review helps other community members make better decisions and rewards excellent service.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
        <div class="bg-gray-50 p-8 border-b flex items-center gap-6">
            <div class="w-20 h-20 rounded-2xl bg-white border overflow-hidden flex-shrink-0 flex items-center justify-center text-3xl">
                <?php if($type === 'product' && $item->getPrimaryImage()): ?>
                <img src="<?php echo e($item->getPrimaryImage()); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover">
                <?php elseif($type === 'service' && $item->getImageUrl()): ?>
                <img src="<?php echo e($item->getImageUrl()); ?>" alt="<?php echo e($item->name); ?>" class="w-full h-full object-cover">
                <?php else: ?>
                <?php echo e($type === 'product' ? '🌿' : '🏗'); ?>

                <?php endif; ?>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-1"><?php echo e(ucfirst($type)); ?> Being Reviewed</p>
                <h2 class="text-xl font-black text-gray-900"><?php echo e($item->name); ?></h2>
                <p class="text-gray-600">by <?php echo e($item->vendor->business_name); ?></p>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <form action="<?php echo e(route('reviews.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="<?php echo e($type); ?>_id" value="<?php echo e($item->id); ?>">
                <input type="hidden" name="vendor_id" value="<?php echo e($item->vendor_id); ?>">
                <input type="hidden" name="is_verified_purchase" value="<?php echo e($is_verified ? 1 : 0); ?>">

                <div class="space-y-8">
                    <!-- Rating Selector -->
                    <div>
                        <label class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-4">Overall Rating</label>
                        <div class="flex items-center gap-4">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <label class="cursor-pointer group">
                                <input type="radio" name="rating" value="<?php echo e($i); ?>" class="hidden peer" required>
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-gray-100 bg-gray-50 text-gray-400 transition-all peer-checked:border-yellow-400 peer-checked:bg-yellow-50 peer-checked:text-yellow-600 hover:bg-white hover:border-yellow-200">
                                    <span class="text-xl font-black"><?php echo e($i); ?></span>
                                </div>
                                </label>
                                <?php endfor; ?>
                                <span class="ml-2 text-gray-400 italic">Stars</span>
                        </div>
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-2">Detail your experience</label>
                        <textarea name="comment" id="comment" rows="6" required placeholder="What did you like? How was the service or quality?..."
                            class="w-full px-6 py-4 rounded-2xl border-gray-200 focus:border-green-500 focus:ring-green-500 bg-gray-50 italic <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('comment')); ?></textarea>
                        <p class="mt-2 text-xs text-gray-400">Minimum 10 characters.</p>
                        <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1 font-bold"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <?php if($is_verified): ?>
                    <div class="bg-green-50 border border-green-100 p-4 rounded-2xl flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        <p class="text-sm text-green-800 font-bold">This will be marked as a <span class="underline">Verified Purchase</span> review.</p>
                    </div>
                    <?php endif; ?>

                    <button type="submit" class="w-full bg-green-900 text-white py-4 rounded-2xl font-black text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                        Submit Review
                    </button>
                    <p class="text-center text-gray-400 text-xs px-8">
                        By submitting, you agree to our community guidelines. Fake or abusive reviews will be removed.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/reviews/create.blade.php ENDPATH**/ ?>