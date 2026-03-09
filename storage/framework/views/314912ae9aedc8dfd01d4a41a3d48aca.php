

<?php $__env->startSection('title', 'My Orders'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">My Orders</h1>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Order #</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Date</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Total</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Status</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900"><?php echo e($order->order_number); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                    <td class="px-6 py-4 font-bold text-green-800">KES <?php echo e(number_format($order->total_amount)); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                            <?php echo e($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                               ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))); ?>">
                            <?php echo e($order->status); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="text-green-700 font-bold hover:underline">View Details</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">You haven't placed any orders yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        <?php echo e($orders->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/orders/index.blade.php ENDPATH**/ ?>