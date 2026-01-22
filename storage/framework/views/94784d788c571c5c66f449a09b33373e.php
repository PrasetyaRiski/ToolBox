<?php $__env->startSection('title', 'RGBA to HEX Converter - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">RGBA to HEX Converter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Convert RGBA color values to HEX format</p>

        <div class="grid grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Red (0-255):</label>
                <input
                    type="number"
                    id="red"
                    value="255"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Green (0-255):</label>
                <input
                    type="number"
                    id="green"
                    value="87"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blue (0-255):</label>
                <input
                    type="number"
                    id="blue"
                    value="51"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alpha (0-1):</label>
                <input
                    type="number"
                    id="alpha"
                    value="1"
                    min="0"
                    max="1"
                    step="0.1"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
        </div>

        <button
            onclick="convert()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Convert to HEX
        </button>

        <div id="result" class="hidden space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HEX:</label>
                <div class="relative">
                    <input
                        type="text"
                        id="hex-output"
                        readonly
                        class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                    >
                    <button onclick="copyHEX()" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color Preview:</label>
                <div id="color-preview" class="w-full h-24 border-2 border-gray-300 dark:border-gray-600 rounded-lg"></div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function convert() {
    const r = document.getElementById('red').value;
    const g = document.getElementById('green').value;
    const b = document.getElementById('blue').value;
    const a = document.getElementById('alpha').value;

    try {
        const response = await fetch('<?php echo e(route("tools.rgba-to-hex")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ r, g, b, a })
        });

        const data = await response.json();

        if (data.hex) {
            document.getElementById('hex-output').value = data.hex;
            document.getElementById('color-preview').style.backgroundColor = `rgba(${r}, ${g}, ${b}, ${a})`;
            document.getElementById('result').classList.remove('hidden');
        } else {
            alert(data.error || 'Invalid RGBA values');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyHEX() {
    const output = document.getElementById('hex-output');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\color\rgba-to-hex.blade.php ENDPATH**/ ?>