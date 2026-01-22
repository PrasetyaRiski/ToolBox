<?php $__env->startSection('title', 'HTML Minifier - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">HTML Minifier</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Minify your HTML code to reduce file size</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter HTML:</label>
            <textarea
                id="input-html"
                rows="12"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none font-mono text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="<html>&#10;  <body>&#10;    <h1>Hello World</h1>&#10;  </body>&#10;</html>"
            ></textarea>
        </div>

        <button
            onclick="minify()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Minify HTML
        </button>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Minified HTML:</label>
                <div class="flex gap-2">
                    <span id="stats" class="text-sm text-gray-600 dark:text-gray-400"></span>
                    <button onclick="copyResult()" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>
            <textarea
                id="output"
                readonly
                rows="12"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 font-mono text-sm text-gray-900 dark:text-white"
            ></textarea>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function minify() {
    const html = document.getElementById('input-html').value;

    if (!html) {
        alert('Please enter HTML code');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.html-minifier")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ html })
        });

        const data = await response.json();

        document.getElementById('output').value = data.minified;

        const originalSize = html.length;
        const minifiedSize = data.minified.length;
        const saved = ((originalSize - minifiedSize) / originalSize * 100).toFixed(2);

        document.getElementById('stats').textContent = `Reduced by ${saved}% (${originalSize} → ${minifiedSize} chars)`;
        document.getElementById('result').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyResult() {
    const output = document.getElementById('output');
    const text = output.value;
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Copied to clipboard!');
    }).catch(err => {
        output.select();
        document.execCommand('copy');
        alert('✓ Copied to clipboard!');
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\coding\html-minifier.blade.php ENDPATH**/ ?>