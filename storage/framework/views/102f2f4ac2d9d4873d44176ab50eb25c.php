<?php $__env->startSection('title', 'Password Generator - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Password Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate strong random passwords</p>

        <div class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password Length: <span id="length-value">16</span></label>
                <input
                    type="range"
                    id="length"
                    min="8"
                    max="64"
                    value="16"
                    oninput="document.getElementById('length-value').textContent = this.value"
                    class="w-full"
                >
            </div>

            <div class="grid grid-cols-2 gap-4">
                <label class="flex items-center text-gray-700 dark:text-gray-300">
                    <input type="checkbox" id="uppercase" checked class="mr-2">
                    <span>Include Uppercase (A-Z)</span>
                </label>
                <label class="flex items-center text-gray-700 dark:text-gray-300">
                    <input type="checkbox" id="lowercase" checked class="mr-2">
                    <span>Include Lowercase (a-z)</span>
                </label>
                <label class="flex items-center text-gray-700 dark:text-gray-300">
                    <input type="checkbox" id="numbers" checked class="mr-2">
                    <span>Include Numbers (0-9)</span>
                </label>
                <label class="flex items-center text-gray-700 dark:text-gray-300">
                    <input type="checkbox" id="symbols" checked class="mr-2">
                    <span>Include Symbols (!@#$...)</span>
                </label>
            </div>
        </div>

        <button
            onclick="generatePassword()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Generate Password
        </button>

        <div id="result" class="hidden">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Generated Password:</label>
            <div class="relative">
                <input
                    type="text"
                    id="password"
                    readonly
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-lg font-mono text-gray-900 dark:text-white"
                >
                <button
                    onclick="copyPassword()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700"
                >
                    Copy
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function generatePassword() {
    const length = document.getElementById('length').value;
    const uppercase = document.getElementById('uppercase').checked;
    const lowercase = document.getElementById('lowercase').checked;
    const numbers = document.getElementById('numbers').checked;
    const symbols = document.getElementById('symbols').checked;

    if (!uppercase && !lowercase && !numbers && !symbols) {
        alert('Please select at least one character type');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.password-generator")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ length, uppercase, lowercase, numbers, symbols })
        });

        const data = await response.json();
        document.getElementById('password').value = data.password;
        document.getElementById('result').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyPassword() {
    const password = document.getElementById('password');
    const text = password.value;
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Password copied to clipboard!');
    }).catch(err => {
        password.select();
        document.execCommand('copy');
        alert('✓ Password copied to clipboard!');
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\misc\password-generator.blade.php ENDPATH**/ ?>