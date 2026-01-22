<?php $__env->startSection('title', 'Semua Kategori - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Semua Kategori Tools</h1>
    <p class="text-gray-600 dark:text-gray-400">Jelajahi semua kategori tools yang tersedia</p>
</div>

<?php if(auth()->guard()->guest()): ?>
<!-- Login Modal for Guest Users -->
<div x-data="{ showModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="showModal = false">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8" @click.stop>
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Login Diperlukan</h3>
                <p class="text-gray-600 dark:text-gray-400">Silakan masuk atau daftar untuk melihat kategori ini</p>
            </div>

            <div class="space-y-3">
                <a href="<?php echo e(route('login')); ?>" class="block w-full bg-primary-600 text-white text-center py-3 rounded-lg font-medium hover:bg-primary-700 transition">
                    Masuk
                </a>
                <a href="<?php echo e(route('register')); ?>" class="block w-full border-2 border-primary-600 text-primary-600 text-center py-3 rounded-lg font-medium hover:bg-primary-50 transition">
                    Daftar Akun Baru
                </a>
                <button @click="showModal = false" class="block w-full text-gray-600 text-center py-2 hover:text-gray-800">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="#" @click.prevent="showModal = true" class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-8 group">
            <div class="text-center">
                <div class="text-5xl mb-4"><?php echo e($category->icon); ?></div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition mb-2">
                    <?php echo e($category->name); ?>

                </h3>
                <?php if($category->description): ?>
                <p class="text-gray-600 dark:text-gray-400 mb-4"><?php echo e($category->description); ?></p>
                <?php endif; ?>
                <p class="text-sm text-gray-500"><?php echo e($category->tools_count); ?> tools</p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-8 group">
        <div class="text-center">
            <div class="text-5xl mb-4"><?php echo e($category->icon); ?></div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition mb-2">
                <?php echo e($category->name); ?>

            </h3>
            <?php if($category->description): ?>
            <p class="text-gray-600 dark:text-gray-400 mb-4"><?php echo e($category->description); ?></p>
            <?php endif; ?>
            <p class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($category->tools_count); ?> tools</p>
        </div>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\categories\index.blade.php ENDPATH**/ ?>