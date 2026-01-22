<?php $__env->startSection('title', 'Search Results - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Search Results</h1>
    <p class="text-gray-600">Showing results for: <strong>"<?php echo e($query); ?>"</strong></p>
</div>

<?php if($tools->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('tools.show', $tool->slug)); ?>" class="bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 group">
            <div class="flex items-start justify-between mb-3">
                <div class="flex items-center">
                    <span class="text-2xl mr-3"><?php echo e($tool->category->icon); ?></span>
                    <div>
                        <h3 class="font-semibold text-lg text-gray-900 group-hover:text-primary-600 transition">
                            <?php echo e($tool->name); ?>

                        </h3>
                        <p class="text-xs text-gray-500"><?php echo e($tool->category->name); ?></p>
                    </div>
                </div>
                <?php if($tool->is_new): ?>
                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">NEW</span>
                <?php endif; ?>
            </div>
            <p class="text-gray-600 text-sm"><?php echo e($tool->description); ?></p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8">
        <?php echo e($tools->links()); ?>

    </div>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <div class="text-6xl mb-4">🔍</div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">No tools found</h2>
        <p class="text-gray-600 mb-6">Try searching with different keywords</p>
        <a href="<?php echo e(route('home')); ?>" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
            Browse All Tools
        </a>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\search.blade.php ENDPATH**/ ?>