<?php $__env->startSection('title', 'Whitespace Remover - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Whitespace Remover</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Remove extra whitespace from your text</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your text:</label>
            <textarea
                id="input-text"
                rows="10"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Paste your text with extra whitespace here..."
            ></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <button onclick="removeWhitespace('extra')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Remove Extra Spaces
            </button>
            <button onclick="removeWhitespace('all')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Remove All Spaces
            </button>
            <button onclick="removeWhitespace('newlines')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Remove Newlines
            </button>
        </div>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                <button onclick="copyResult()" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                    📋 Copy
                </button>
            </div>
            <textarea
                id="output"
                readonly
                rows="10"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
            ></textarea>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function removeWhitespace(type) {
    const text = document.getElementById('input-text').value;

    if (!text) {
        alert('Please enter some text');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.whitespace-remover")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ text, type })
        });

        const data = await response.json();
        document.getElementById('output').value = data.result;
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\text\whitespace-remover.blade.php ENDPATH**/ ?>