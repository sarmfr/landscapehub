

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="<?php echo e(route('quotes.index')); ?>" class="inline-flex items-center text-gray-500 hover:text-green-800 font-bold transition-all mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Requests
            </a>
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="inline-block px-3 py-1 bg-green-800 text-white text-xs font-black uppercase tracking-widest rounded-full">
                            <?php echo e($quote->category->name); ?>

                        </span>
                        <span class="text-sm text-gray-500">Posted <?php echo e($quote->created_at->diffForHumans()); ?></span>
                    </div>
                    <h1 class="text-4xl font-black text-gray-900">Project Details</h1>
                </div>
                <div class="flex items-center gap-3">
                    <?php if($quote->status === 'posted'): ?>
                    <span class="px-6 py-2 bg-blue-50 text-blue-700 rounded-2xl font-black uppercase tracking-widest text-xs border border-blue-100">Finding Vendors</span>
                    <?php elseif($quote->status === 'accepted'): ?>
                    <span class="px-6 py-2 bg-green-50 text-green-700 rounded-2xl font-black uppercase tracking-widest text-xs border border-green-100">Hired</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Project Info -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <?php if($quote->image): ?>
                    <div class="h-80 w-full overflow-hidden">
                        <img src="<?php echo e(Storage::url($quote->image)); ?>" alt="Project image" class="w-full h-full object-cover">
                    </div>
                    <?php endif; ?>
                    <div class="p-8">
                        <div class="flex items-center text-gray-600 mb-6">
                            <svg class="w-6 h-6 mr-2 text-green-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-lg font-bold"><?php echo e($quote->location); ?></span>
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-gray-400 mb-4">Requirements</h3>
                        <div class="text-lg text-gray-700 leading-relaxed whitespace-pre-wrap"><?php echo e($quote->description); ?></div>
                    </div>
                </div>

                <!-- Responses Section -->
                <div>
                    <h2 class="text-2xl font-black text-gray-900 mb-6">Vendor Proposals (<?php echo e($quote->responses->count()); ?>)</h2>

                    <?php if($quote->responses->isEmpty()): ?>
                    <div class="bg-white rounded-3xl p-10 text-center border-2 border-dashed border-gray-100 shadow-sm">
                        <p class="text-gray-500 font-bold">Waiting for vendors to review your request and submit proposals.</p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-6">
                        <?php $__currentLoopData = $quote->responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-3xl shadow-md p-8 border hover:border-green-300 transition-all <?php echo e($response->status === 'accepted' ? 'ring-2 ring-green-600 border-transparent bg-green-50' : ''); ?>">
                            <div class="flex flex-col md:flex-row justify-between gap-6">
                                <div class="flex-grow">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-800 font-black text-xl uppercase">
                                            <?php echo e(substr($response->vendor->business_name, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <h4 class="text-xl font-black text-gray-900"><?php echo e($response->vendor->business_name); ?></h4>
                                            <span class="text-sm text-gray-500">Proposal sent <?php echo e($response->created_at->diffForHumans()); ?></span>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 leading-relaxed mb-4"><?php echo e($response->description); ?></p>
                                </div>
                                <div class="flex flex-col justify-between items-end gap-4 min-w-[200px]">
                                    <div class="text-right">
                                        <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Quoted Price</p>
                                        <p class="text-3xl font-black text-green-800">KES <?php echo e(number_format($response->quoted_price)); ?></p>
                                    </div>

                                    <?php if($quote->status === 'posted'): ?>
                                    <form action="<?php echo e(route('quotes.accept', $response)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="bg-green-800 text-white font-black px-8 py-3 rounded-2xl hover:scale-105 hover:bg-green-700 active:scale-95 transition-all shadow-lg w-full md:w-auto">
                                            Accept & Hire
                                        </button>
                                    </form>
                                    <?php elseif($response->status === 'accepted'): ?>
                                    <span class="bg-green-600 text-white px-8 py-3 rounded-2xl font-black flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Currently Hired
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <div class="bg-green-800 rounded-3xl p-8 text-white shadow-xl">
                    <h3 class="text-xl font-black mb-4">How it works</h3>
                    <ul class="space-y-4 opacity-90 text-sm">
                        <li class="flex items-start gap-4">
                            <span class="w-6 h-6 bg-white text-green-800 rounded-full flex items-center justify-center font-black flex-shrink-0">1</span>
                            <p>Vendors review your project details and submitted photo.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-6 h-6 bg-white text-green-800 rounded-full flex items-center justify-center font-black flex-shrink-0">2</span>
                            <p>They send personalized price proposals and messages.</p>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="w-6 h-6 bg-white text-green-800 rounded-full flex items-center justify-center font-black flex-shrink-0">3</span>
                            <p>Accept the best offer to start working with the vendor.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\landscapehub\resources\views/quotes/show.blade.php ENDPATH**/ ?>