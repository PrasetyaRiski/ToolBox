<?php $__env->startSection('title', 'My Favorites - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">My Favorite Tools</h1>
    <p class="text-gray-600 dark:text-gray-400">Quick access to your frequently used tools</p>
</div>

<?php if($favorites->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $favorite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('tools.show', $favorite->tool->slug)); ?>" class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 group relative">
            <button
                onclick="event.preventDefault(); removeFavorite(<?php echo e($favorite->tool->id); ?>)"
                class="absolute top-4 right-4 text-yellow-500 hover:text-gray-400 dark:hover:text-gray-500 text-xl"
                title="Remove from favorites"
            >
                ⭐
            </button>

            <div class="flex items-center mb-3">
                <span class="text-2xl mr-3"><?php echo e($favorite->tool->category->icon); ?></span>
                <div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                        <?php echo e($favorite->tool->name); ?>

                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($favorite->tool->category->name); ?></p>
                </div>
            </div>
            <p class="text-gray-600 dark:text-gray-400 text-sm"><?php echo e($favorite->tool->description); ?></p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php else: ?>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
        <div class="text-6xl mb-4">⭐</div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No favorites yet</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Start adding tools to your favorites for quick access</p>
        <a href="<?php echo e(route('home')); ?>" class="inline-block bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition">
            Browse Tools
        </a>
    </div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
function removeFavorite(toolId) {
    if (confirm('Remove this tool from favorites?')) {
        fetch('<?php echo e(route("favorites.toggle")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ tool_id: toolId })
        })
        .then(() => {
            location.reload();
        });
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\favorites\index.blade.php ENDPATH**/ ?>