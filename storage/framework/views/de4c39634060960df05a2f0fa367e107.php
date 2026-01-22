<?php $__env->startSection('title', $category->name . ' - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <div class="flex items-center mb-4">
        <span class="text-4xl mr-4"><?php echo e($category->icon); ?></span>
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white"><?php echo e($category->name); ?></h1>
            <?php if($category->description): ?>
            <p class="text-gray-600 dark:text-gray-400 mt-2"><?php echo e($category->description); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__currentLoopData = $tools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 group relative">
        <!-- Favorite Button -->
        <?php if(auth()->guard()->check()): ?>
        <button
            onclick="toggleFavorite(<?php echo e($tool->id); ?>, this)"
            class="absolute top-4 right-4 text-xl hover:scale-125 transition-transform favorite-btn"
            data-tool-id="<?php echo e($tool->id); ?>"
            title="Add to favorites"
        >
            <?php if(auth()->user()->favorites->contains('tool_id', $tool->id)): ?>
                ⭐
            <?php else: ?>
                ☆
            <?php endif; ?>
        </button>
        <?php endif; ?>

        <a href="<?php echo e(route('tools.show', $tool->slug)); ?>" class="block">
            <div class="flex items-start justify-between mb-3 pr-8">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                    <?php echo e($tool->name); ?>

                </h3>
                <?php if($tool->is_new): ?>
                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">NEW</span>
                <?php endif; ?>
            </div>
            <p class="text-gray-600 dark:text-gray-400"><?php echo e($tool->description); ?></p>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Used <?php echo e(number_format($tool->usage_count)); ?> times
            </div>
        </a>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-8">
    <?php echo e($tools->links()); ?>

</div>

<?php if(auth()->guard()->check()): ?>
<?php $__env->startPush('scripts'); ?>
<script>
function toggleFavorite(toolId, btn) {
    fetch('<?php echo e(route("favorites.toggle")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        body: JSON.stringify({ tool_id: toolId })
    })
    .then(response => response.json())
    .then(data => {
        btn.textContent = data.favorited ? '⭐' : '☆';
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\categories\show.blade.php ENDPATH**/ ?>