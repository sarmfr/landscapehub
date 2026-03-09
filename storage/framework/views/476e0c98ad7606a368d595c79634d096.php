

<?php $__env->startSection('title', 'Book ' . $service->name); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="mb-8">
        <a href="<?php echo e(route('services.show', $service->slug)); ?>" class="text-green-700 hover:underline">← Back to Service</a>
        <h1 class="text-3xl font-bold mt-2">Book <?php echo e($service->name); ?></h1>
        <p class="text-gray-600">Offered by <?php echo e($service->vendor->business_name); ?></p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border">
        <div class="grid grid-cols-1 md:grid-cols-3">
            <div class="md:col-span-1 bg-gray-100 p-6 border-r">
                <div class="h-32 bg-gray-300 rounded-lg mb-4 overflow-hidden">
                    <?php if($service->getImageUrl()): ?>
                    <img src="<?php echo e($service->getImageUrl()); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-4xl">🏗</div>
                    <?php endif; ?>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-black tracking-widest">Pricing</p>
                        <?php if($service->pricing_type === 'fixed'): ?>
                        <p class="text-xl font-bold text-green-800">KES <?php echo e(number_format($service->price)); ?></p>
                        <?php else: ?>
                        <p class="text-lg font-bold text-green-800">Custom Quote</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 p-8">
                <form action="<?php echo e(route('bookings.store', $service->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="space-y-6">
                        <div>
                            <label for="booking_date" class="block text-sm font-bold text-gray-700 mb-2">Preferred Date</label>
                            <input type="date" name="booking_date" id="booking_date" required
                                class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>">
                            <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-bold text-gray-700 mb-2">Service Location (Town/Area)</label>
                            <input type="text" name="location" id="location" required placeholder="e.g. Karen, Nairobi"
                                class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Describe Your Requirements</label>
                            <textarea name="description" id="description" rows="4" required placeholder="Tell the professional what you need..."
                                class="w-full px-4 py-3 rounded-xl border-gray-300 focus:ring-green-500 focus:border-green-500 <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Attach Reference Photo (Optional)</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="w-full px-4 py-2 border rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>

                        <button type="submit" class="w-full bg-green-700 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-800 transition shadow-lg transform hover:-translate-y-1">
                            Confirm Booking Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/bookings/create.blade.php ENDPATH**/ ?>