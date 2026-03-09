

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-green-800">🌿 LandScapeHub</h1>
            <p class="text-gray-600 mt-2">Join Our Community</p>
        </div>

        <?php if($errors->any()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('register')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Full Name</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="Your name">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Email Address</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="you@example.com">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Phone Number</label>
                <input type="tel" name="phone" value="<?php echo e(old('phone')); ?>" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="+254 7XX XXX XXX">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Account Type</label>
                <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600">
                    <option value="">-- Select Account Type --</option>
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor/Service Provider</option>
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="At least 8 characters">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600"
                    placeholder="Confirm your password">
            </div>
            <button type="submit" class="w-full bg-green-700 text-white py-2 rounded-lg font-semibold hover:bg-green-800 transition">
                Create Account
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-600">Already have an account?
                <a href="<?php echo e(route('login')); ?>" class="text-green-700 font-semibold hover:underline">Login here</a>
            </p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/auth/register.blade.php ENDPATH**/ ?>