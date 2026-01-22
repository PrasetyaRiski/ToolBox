<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="copyright" content="© 2026 Prasetya Riski Wa'afan. Semua hak cipta dilindungi undang-undang.">
    <meta name="author" content="Prasetya Riski Wa'afan">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ProductiviTools - Semua Tools Online dalam Satu Tempat">
    <meta name="format-detection" content="telephone=no">
    <!-- Perlindungan Harta Cipta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="copyright" href="/LICENSE">
    <title><?php echo $__env->yieldContent('title', 'Toolbox - Semua Tools Online dalam Satu Tempat'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Platform produktivitas all-in-one gratis'); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script>
        // Prevent flash of wrong theme
        if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen transition-colors duration-300">
    <!-- Header -->
    <header class="bg-white/60 dark:bg-gray-900/60 backdrop-blur-xl shadow-sm sticky top-0 z-50 border-b border-gray-200/50 dark:border-gray-800/50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-2 group">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 p-2 rounded-2xl group-hover:scale-110 transition-transform shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Toolbox
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition font-medium">Beranda</a>
                    <a href="<?php echo e(route('categories.index')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition font-medium">Kategori</a>
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('favorites.index')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition font-medium">Favorit</a>
                    <?php endif; ?>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode"
                            class="p-2 rounded-2xl bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-300 group">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-700 group-hover:text-primary-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-gray-300 group-hover:text-yellow-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <?php if(auth()->guard()->check()): ?>
                    <!-- User Menu -->
                    <div x-data="{ open: false }" class="relative hidden md:block">
                        <button @click="open = !open" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl hover:shadow-lg transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="font-medium"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute right-0 mt-2 w-48 bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-2xl shadow-lg py-2 z-10">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg mx-1">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Keluar</span>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Auth Links -->
                    <div class="hidden md:flex items-center space-x-3">
                        <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition font-medium">Masuk</a>
                        <a href="<?php echo e(route('register')); ?>" class="px-6 py-2 bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all font-medium">Daftar</a>
                    </div>
                    <?php endif; ?>

                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg">
            <div class="px-4 py-3 space-y-2">
                <a href="<?php echo e(route('home')); ?>" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Beranda</a>
                <a href="<?php echo e(route('categories.index')); ?>" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Kategori</a>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('favorites.index')); ?>" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Favorit</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Keluar</button>
                </form>
                <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">Masuk</a>
                <a href="<?php echo e(route('register')); ?>" class="block px-3 py-2 rounded-lg text-white bg-gradient-to-r from-primary-600 to-purple-600 hover:shadow-lg transition">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent mb-3">Toolbox</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Platform produktivitas all-in-one untuk semua kebutuhan Anda.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">Beranda</a></li>
                        <li><a href="<?php echo e(route('categories.index')); ?>" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition">Kategori</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Informasi</h4>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Dibuat dengan ❤️ menggunakan Laravel 12, Tailwind CSS & Alpine.js</p>
                </div>
            </div>
            <div class="text-center pt-8 border-t border-gray-200 dark:border-gray-800">
                <p class="text-gray-600 dark:text-gray-400 text-sm">&copy; <?php echo e(date('Y')); ?> Prasetya Riski Wa'afan. Semua hak cipta dilindungi undang-undang.</p>
                <p class="text-gray-500 dark:text-gray-500 text-xs mt-2">⚠️ Karya ini dilindungi oleh hak cipta. Pelarangan ketat untuk penyalahgunaan.</p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\layouts\app.blade.php ENDPATH**/ ?>