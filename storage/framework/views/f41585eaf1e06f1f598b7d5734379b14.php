

<?php $__env->startSection('title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl shadow-xl border p-6 text-center">
                <div class="w-24 h-24 bg-green-100 text-green-700 rounded-full flex items-center justify-center text-4xl font-black mx-auto mb-4">
                    <?php echo e(substr($user->name, 0, 1)); ?>

                </div>
                <h2 class="text-xl font-black text-gray-900"><?php echo e($user->name); ?></h2>
                <p class="text-gray-500 text-sm italic"><?php echo e($user->email); ?></p>
                <div class="mt-6 pt-6 border-t space-y-2">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="block w-full py-2 bg-gray-50 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition">Edit Profile</a>
                    <a href="<?php echo e(route('profile.password')); ?>" class="block w-full py-2 bg-gray-50 text-gray-700 rounded-xl font-bold hover:bg-gray-100 transition">Change Password</a>
                </div>
            </div>

            <div class="bg-green-900 text-white rounded-3xl shadow-xl p-6">
                <h3 class="font-black text-lg mb-4">Account Overview</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-green-300">Total Orders</span>
                        <span class="font-bold"><?php echo e($user->orders->count()); ?></span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-green-300">Active Bookings</span>
                        <span class="font-bold"><?php echo e($user->bookings->where('status', 'pending')->count()); ?></span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-green-300">Reviews Written</span>
                        <span class="font-bold"><?php echo e($user->reviews->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
                <div class="p-8 border-b flex justify-between items-center bg-gray-50">
                    <h2 class="text-2xl font-black text-gray-900">Recent Orders</h2>
                    <a href="<?php echo e(route('orders.index')); ?>" class="text-green-700 font-bold hover:underline">View All →</a>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 text-gray-400 text-xs uppercase font-black tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Order #</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">Total</th>
                                    <th class="px-8 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y italic">
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-8 py-6 font-bold text-gray-900"><?php echo e($order->order_number); ?></td>
                                    <td class="px-8 py-6 text-gray-600"><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td class="px-8 py-6 font-black text-green-800">KES <?php echo e(number_format($order->total_amount)); ?></td>
                                    <td class="px-8 py-6 text-sm">
                                        <span class="px-3 py-1 rounded-full font-black uppercase text-[10px] 
                                            <?php echo e($order->payment_status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo e($order->payment_status); ?>

                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="text-green-700 font-bold hover:underline">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">No orders found. <a href="<?php echo e(route('products')); ?>" class="text-green-700 underline font-bold">Start shopping!</a></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
                <div class="p-8 border-b flex justify-between items-center bg-gray-50">
                    <h2 class="text-2xl font-black text-gray-900">Recent Service Bookings</h2>
                    <a href="<?php echo e(route('bookings.my')); ?>" class="text-green-700 font-bold hover:underline">View All →</a>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 text-gray-400 text-xs uppercase font-black tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Service</th>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4">Provider</th>
                                    <th class="px-8 py-4 text-center">Status</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y italic">
                                <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-8 py-6 font-bold text-gray-900"><?php echo e($booking->service->name ?? 'Custom Service'); ?></td>
                                    <td class="px-8 py-6 text-gray-600"><?php echo e(\Carbon\Carbon::parse($booking->booking_date)->format('M d, Y')); ?></td>
                                    <td class="px-8 py-6 text-gray-600"><?php echo e($booking->vendor->business_name ?? 'N/A'); ?></td>
                                    <td class="px-8 py-6 text-center text-sm">
                                        <span class="px-3 py-1 rounded-full font-black uppercase text-[10px] 
                                            <?php echo e($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'); ?>">
                                            <?php echo e($booking->status); ?>

                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="<?php echo e(route('bookings.show', $booking->id)); ?>" class="text-green-700 font-bold hover:underline">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-gray-500 italic">No bookings found. <a href="<?php echo e(route('services')); ?>" class="text-green-700 underline font-bold">Book a professional!</a></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/profile/show.blade.php ENDPATH**/ ?>