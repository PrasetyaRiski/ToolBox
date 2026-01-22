<?php $__env->startSection('title', 'Color Shades Generator - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Color Shades Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate lighter and darker shades of any color</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Choose Color:</label>
            <div class="flex gap-4">
                <input
                    type="text"
                    id="color-input"
                    placeholder="#FF5733"
                    value="#FF5733"
                    class="flex-1 border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
                <input
                    type="color"
                    id="color-picker"
                    value="#FF5733"
                    class="w-20 h-14 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer"
                    onchange="document.getElementById('color-input').value = this.value"
                >
            </div>
        </div>

        <button
            onclick="generateShades()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Generate Shades
        </button>

        <div id="result" class="hidden">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shades & Tints</h3>
            <div id="shades-container" class="grid grid-cols-5 gap-4"></div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function generateShades() {
    const color = document.getElementById('color-input').value;

    if (!color) {
        alert('Please enter a color');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.color-shades")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ color })
        });

        const data = await response.json();

        if (data.shades) {
            const container = document.getElementById('shades-container');
            container.innerHTML = '';

            data.shades.forEach(shade => {
                const div = document.createElement('div');
                div.className = 'text-center';
                div.innerHTML = `
                    <div class="w-full h-24 rounded-lg border-2 border-gray-300 dark:border-gray-600 mb-2 cursor-pointer hover:scale-105 transition"
                         style="background-color: ${shade}"
                         onclick="copyColor('${shade}')"
                         title="Click to copy"></div>
                    <p class="text-xs font-mono text-gray-600 dark:text-gray-400">${shade}</p>
                `;
                container.appendChild(div);
            });

            document.getElementById('result').classList.remove('hidden');
        } else {
            alert(data.error || 'Invalid color');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyColor(color) {
    navigator.clipboard.writeText(color).then(() => {
        alert('✓ Copied: ' + color);
    }).catch(err => {
        console.error('Copy failed:', err);
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\color\color-shades.blade.php ENDPATH**/ ?>