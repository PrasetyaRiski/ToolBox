<?php $__env->startSection('title', 'HEX to RGBA Converter - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">HEX to RGBA Converter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Convert HEX color codes to RGBA format</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HEX Color:</label>
            <div class="flex gap-4">
                <input
                    type="text"
                    id="hex-input"
                    placeholder="#FF5733 or FF5733"
                    class="flex-1 border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
                <input
                    type="color"
                    id="color-picker"
                    value="#FF5733"
                    class="w-20 h-14 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer"
                    onchange="document.getElementById('hex-input').value = this.value"
                >
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opacity (0-1):</label>
            <input
                type="number"
                id="opacity"
                value="1"
                min="0"
                max="1"
                step="0.1"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
            >
        </div>

        <button
            onclick="convert()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Convert to RGBA
        </button>

        <div id="result" class="hidden space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">RGBA:</label>
                <div class="relative">
                    <input
                        type="text"
                        id="rgba-output"
                        readonly
                        class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                    >
                    <button onclick="copyRGBA()" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
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
    const hex = document.getElementById('hex-input').value;
    const opacity = document.getElementById('opacity').value;

    if (!hex) {
        alert('Please enter a HEX color');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.hex-to-rgba")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ hex, opacity })
        });

        const data = await response.json();

        if (data.rgba) {
            document.getElementById('rgba-output').value = data.rgba;
            document.getElementById('color-preview').style.backgroundColor = data.rgba;
            document.getElementById('result').classList.remove('hidden');
        } else {
            alert(data.error || 'Invalid HEX color');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyRGBA() {
    const output = document.getElementById('rgba-output');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\color\hex-to-rgba.blade.php ENDPATH**/ ?>