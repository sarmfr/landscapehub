

<?php $__env->startSection('title', 'Shopping Cart'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    <?php if(count($items) > 0): ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-6 border-b flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold"><?php echo e($item['product']->name); ?></h3>
                        <p class="text-gray-600 text-sm">Quantity: <?php echo e($item['quantity']); ?></p>
                        <p class="text-green-700 font-bold mt-2">KES <?php echo e(number_format($item['subtotal'])); ?></p>
                    </div>
                    <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                        <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                    </form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="bg-white rounded-lg shadow p-6 h-fit">
            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
            <div class="space-y-3 mb-6 border-b pb-4">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>KES <?php echo e(number_format($total)); ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Shipping:</span>
                    <span>Free</span>
                </div>
            </div>
            <div class="flex justify-between font-bold text-lg mb-6">
                <span>Total:</span>
                <span class="text-green-700">KES <?php echo e(number_format($total)); ?></span>
            </div>

            <?php if(auth()->guard()->check()): ?>
            <form action="<?php echo e(route('cart.checkout')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Mpesa Phone Number</label>
                    <input type="tel" name="mpesa_phone" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                        placeholder="+254 7XX XXX XXX">
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                    Proceed to Payment
                </button>
            </form>
            <?php else: ?>
            <a href="<?php echo e(route('login')); ?>" class="block w-full text-center bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-800">
                Login to Checkout
            </a>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <p class="text-gray-600 text-lg mb-6">Your cart is empty</p>
        <a href="<?php echo e(route('products')); ?>" class="inline-block bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800">
            Continue Shopping
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/cart.blade.php ENDPATH**/ ?>