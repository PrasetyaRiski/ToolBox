<?php $__env->startSection('title', 'JSON Formatter - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">JSON Formatter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Format and validate JSON data</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter JSON:</label>
            <textarea
                id="input-json"
                rows="10"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none font-mono text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder='{"name":"John","age":30,"city":"New York"}'
            ></textarea>
        </div>

        <button
            onclick="formatJSON()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Format JSON
        </button>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Formatted JSON:</label>
                <div>
                    <span id="valid-badge" class="mr-2"></span>
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

        <div id="error" class="hidden mt-4 p-4 bg-red-50 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 rounded-lg">
            <p class="text-red-600 dark:text-red-400 font-semibold">Invalid JSON</p>
            <p id="error-message" class="text-red-500 dark:text-red-400 text-sm mt-2"></p>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function formatJSON() {
    const json = document.getElementById('input-json').value;

    if (!json) {
        alert('Please enter JSON');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.json-formatter")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ json })
        });

        const data = await response.json();

        if (data.valid) {
            document.getElementById('output').value = data.formatted;
            document.getElementById('valid-badge').innerHTML = '<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">✓ Valid JSON</span>';
            document.getElementById('result').classList.remove('hidden');
            document.getElementById('error').classList.add('hidden');
        } else {
            document.getElementById('error-message').textContent = data.error;
            document.getElementById('error').classList.remove('hidden');
            document.getElementById('result').classList.add('hidden');
        }
    } catch (error) {
        document.getElementById('error-message').textContent = error.message;
        document.getElementById('error').classList.remove('hidden');
        document.getElementById('result').classList.add('hidden');
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\coding\json-formatter.blade.php ENDPATH**/ ?>