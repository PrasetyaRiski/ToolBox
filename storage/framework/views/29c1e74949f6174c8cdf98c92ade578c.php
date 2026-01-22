<?php $__env->startSection('title', 'Toolbox - Semua Tools Online dalam Satu Tempat'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section with Elegant Design -->
<div class="relative overflow-hidden py-20 md:py-32">
    <!-- Dynamic mesh gradient background -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/30 dark:from-gray-900 dark:via-slate-900 dark:to-gray-900 -z-10"></div>

    <!-- Animated gradient mesh -->
    <div class="absolute inset-0 opacity-30 dark:opacity-20 -z-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-cyan-400/30 dark:from-blue-600/20 dark:to-cyan-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen blur-3xl animate-float"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-gradient-to-br from-purple-400/30 to-pink-400/30 dark:from-purple-600/20 dark:to-pink-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-gradient-to-br from-indigo-400/30 to-violet-400/30 dark:from-indigo-600/20 dark:to-violet-600/20 rounded-full mix-blend-multiply dark:mix-blend-screen blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="text-center relative z-10 px-4">
        <!-- Refined badge with glow -->
        <div class="inline-flex items-center px-6 py-3 bg-white/70 dark:bg-gray-800/70 backdrop-blur-xl rounded-full shadow-lg shadow-blue-500/10 dark:shadow-blue-500/5 mb-8 hover:shadow-xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/10 hover:scale-105 transition-all duration-500 cursor-default group">
            <span class="relative flex h-3 w-3 mr-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
            </span>
            <span class="text-sm font-semibold bg-gradient-to-r from-gray-700 to-gray-900 dark:from-gray-200 dark:to-gray-100 bg-clip-text text-transparent tracking-wide">15+ Premium Tools Available</span>
        </div>

        <!-- Refined heading with animation -->
        <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold text-gray-900 dark:text-white mb-6 leading-tight tracking-tight animate-fade-in">
            All <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent animate-gradient bg-[length:200%_auto]">Online Tools</span><br>
            <span class="text-gray-800 dark:text-gray-100">in One Place</span>
        </h1>

        <!-- Refined description -->
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed font-light animate-fade-in-up" style="animation-delay: 0.1s;">
            Boost your productivity with the most complete collection of free online tools
        </p>

        <!-- Elegant Search Bar -->
        <div class="max-w-2xl mx-auto mb-10 animate-fade-in-up" style="animation-delay: 0.2s;">
            <form action="<?php echo e(route('search')); ?>" method="GET" class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-3xl blur-xl opacity-0 group-hover:opacity-30 dark:group-hover:opacity-20 transition-all duration-500"></div>
                <div class="relative flex items-center bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-lg shadow-gray-200/50 dark:shadow-gray-900/50 hover:shadow-2xl hover:shadow-blue-500/20 dark:hover:shadow-blue-500/10 hover:scale-[1.02] transition-all duration-500">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 ml-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        name="q"
                        placeholder="Cari tools yang Anda butuhkan..."
                        class="flex-1 px-4 py-4 bg-transparent text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 outline-none text-base border-0"
                    >
                    <button type="submit" class="m-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-3 rounded-2xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/50 hover:scale-105 active:scale-95 transition-all duration-300 font-semibold text-sm">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <?php if(auth()->guard()->guest()): ?>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s;">
            <a href="<?php echo e(route('register')); ?>" class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl shadow-xl shadow-blue-500/30 hover:shadow-2xl hover:shadow-blue-500/50 hover:scale-105 active:scale-95 transition-all duration-500 font-semibold text-sm overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <svg class="w-5 h-5 mr-2 relative z-10 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span class="relative z-10">Get Started Free</span>
            </a>
            <a href="<?php echo e(route('categories.index')); ?>" class="group relative inline-flex items-center px-8 py-4 bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl text-gray-700 dark:text-gray-300 rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-500 font-semibold text-sm border border-gray-200/50 dark:border-gray-700/50 hover:border-blue-500/50 dark:hover:border-blue-500/50 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-indigo-50/50 dark:from-blue-950/50 dark:to-indigo-950/50 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <span class="relative z-10">Browse All Tools</span>
                <svg class="w-5 h-5 ml-2 relative z-10 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if(auth()->guard()->guest()): ?>
<!-- Login Modal for Guest Users -->
<div x-data="{ showModal: false }" x-cloak>
    <!-- Modal Backdrop -->
    <div x-show="showModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         @click.self="showModal = false"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100">
        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-xl max-w-md w-full p-8"
             @click.stop
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="text-center mb-6">
                <div class="mx-auto w-20 h-20 bg-gradient-to-br from-primary-500 to-purple-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Login Diperlukan</h3>
                <p class="text-gray-600 dark:text-gray-400">Silakan masuk atau daftar untuk menggunakan tools ini</p>
            </div>

            <div class="space-y-3">
                <a href="<?php echo e(route('login')); ?>" class="block w-full bg-gradient-to-r from-primary-600 to-purple-600 text-white text-center py-4 rounded-xl font-medium hover:shadow-xl hover:scale-105 transition-all duration-300">
                    Masuk
                </a>
                <a href="<?php echo e(route('register')); ?>" class="block w-full border-2 border-primary-600 dark:border-primary-500 text-primary-600 dark:text-primary-400 text-center py-4 rounded-xl font-medium hover:bg-primary-50 dark:hover:bg-primary-950 transition-all duration-300">
                    Daftar Akun Baru
                </a>
                <button @click="showModal = false" class="block w-full text-gray-600 dark:text-gray-400 text-center py-3 hover:text-gray-800 dark:hover:text-gray-200 transition">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Featured Tools (Guest View) -->
    <?php if($featuredTools->count() > 0): ?>
    <section class="mb-20 mt-16">
        <div class="mb-12 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">
                <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Featured</span> Tools
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 font-light">Most popular and frequently used tools</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $featuredTools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="#" @click.prevent="showModal = true" class="group relative bg-gradient-to-br from-white/80 to-white/60 dark:from-gray-800/80 dark:to-gray-800/60 backdrop-blur-xl rounded-3xl p-6 hover:shadow-2xl hover:shadow-blue-500/10 dark:hover:shadow-blue-500/5 hover:scale-105 hover:-translate-y-1 transition-all duration-500 border border-gray-200/50 dark:border-gray-700/50 hover:border-blue-500/50 dark:hover:border-blue-500/30 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-purple-500/0 group-hover:from-blue-500/5 group-hover:to-purple-500/5 dark:group-hover:from-blue-500/10 dark:group-hover:to-purple-500/10 transition-all duration-500 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-4">
                        <div class="text-5xl group-hover:scale-125 group-hover:rotate-6 transition-all duration-500"><?php echo e($tool->category->icon); ?></div>
                        <?php if($tool->is_new): ?>
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30 animate-pulse">NEW</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                        <?php echo e($tool->name); ?>

                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"><?php echo e($tool->description); ?></p>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- Tool Categories (Guest View) -->
    <section>
        <div class="mb-12 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 tracking-tight">
                Tool <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-400 dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">Categories</span>
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 font-light">Explore tools by category</p>
        </div>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mb-16">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4 group">
                <div class="flex items-center gap-4">
                    <div class="text-5xl md:text-6xl group-hover:scale-110 transition-transform duration-500"><?php echo e($category->icon); ?></div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight"><?php echo e($category->name); ?></h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1 font-light"><?php echo e($category->description); ?></p>
                    </div>
                </div>
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium flex items-center gap-2 group text-sm">
                    Lihat semua
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php $__currentLoopData = $category->activeTools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="#" @click.prevent="showModal = true" class="group relative bg-gradient-to-br from-white/90 to-white/70 dark:from-gray-800/90 dark:to-gray-800/70 backdrop-blur-xl rounded-3xl p-6 border border-gray-200/50 dark:border-gray-700/50 hover:shadow-2xl hover:shadow-blue-500/10 dark:hover:shadow-blue-500/5 hover:scale-105 hover:-translate-y-1 hover:border-blue-400 dark:hover:border-blue-600/50 transition-all duration-500 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/0 to-indigo-500/0 group-hover:from-blue-500/5 group-hover:to-indigo-500/5 dark:group-hover:from-blue-500/10 dark:group-hover:to-indigo-500/10 transition-all duration-500 rounded-3xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                    <?php echo e($tool->name); ?>

                                </h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed"><?php echo e(Str::limit($tool->description, 60)); ?></p>
                            </div>
                            <?php if($tool->is_new): ?>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/30 ml-3 shrink-0 animate-pulse">NEW</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>
</div>
<?php else: ?>
<!-- Authenticated User View -->
<!-- Featured Tools -->
<?php if($featuredTools->count() > 0): ?>
<section class="mb-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Tools Unggulan</h2>
            <p class="text-gray-600 dark:text-gray-400">Tools paling populer dan sering digunakan</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php $__currentLoopData = $featuredTools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-hover group relative">
            <!-- Favorite Button -->
            <button
                onclick="toggleFavorite(<?php echo e($tool->id); ?>, this)"
                class="absolute top-4 right-4 text-xl hover:scale-125 transition-transform z-10 favorite-btn"
                data-tool-id="<?php echo e($tool->id); ?>"
                title="Add to favorites"
            >
                <?php if(auth()->user()->favorites->contains('tool_id', $tool->id)): ?>
                    ⭐
                <?php else: ?>
                    ☆
                <?php endif; ?>
            </button>

            <a href="<?php echo e(route('tools.show', $tool->slug)); ?>" class="block">
                <div class="flex items-start justify-between mb-4 pr-8">
                    <div class="text-4xl transform group-hover:scale-110 transition-transform"><?php echo e($tool->category->icon); ?></div>
                    <?php if($tool->is_new): ?>
                    <span class="badge-new">NEW</span>
                    <?php endif; ?>
                </div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                    <?php echo e($tool->name); ?>

                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($tool->description); ?></p>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php endif; ?>

<!-- Tool Categories -->
<section>
    <div class="mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">Kategori Tools</h2>
        <p class="text-gray-600 dark:text-gray-400">Jelajahi tools berdasarkan kategori</p>
    </div>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="text-4xl md:text-5xl"><?php echo e($category->icon); ?></div>
                <div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($category->name); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mt-1"><?php echo e($category->description); ?></p>
                </div>
            </div>
            <a href="<?php echo e(route('categories.show', $category->slug)); ?>" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium flex items-center gap-2 group">
                Lihat semua
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $category->activeTools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card group hover:scale-105 transition-all duration-300 relative">
                <!-- Favorite Button -->
                <button
                    onclick="toggleFavorite(<?php echo e($tool->id); ?>, this)"
                    class="absolute top-4 right-4 text-lg hover:scale-125 transition-transform z-10 favorite-btn"
                    data-tool-id="<?php echo e($tool->id); ?>"
                    title="Add to favorites"
                >
                    <?php if(auth()->user()->favorites->contains('tool_id', $tool->id)): ?>
                        ⭐
                    <?php else: ?>
                        ☆
                    <?php endif; ?>
                </button>

                <a href="<?php echo e(route('tools.show', $tool->slug)); ?>" class="block">
                    <div class="flex items-start justify-between pr-8">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                                <?php echo e($tool->name); ?>

                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e(Str::limit($tool->description, 60)); ?></p>
                        </div>
                        <?php if($tool->is_new): ?>
                        <span class="badge-new ml-3">NEW</span>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\home.blade.php ENDPATH**/ ?>