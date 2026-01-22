<?php $__env->startSection('title', 'QR Code Generator - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">QR Code Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate QR codes for your links or text</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter text or URL:</label>
            <input
                type="text"
                id="qr-text"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="https://example.com or any text"
            >
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Size:</label>
            <select id="qr-size" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <option value="150">150x150</option>
                <option value="200" selected>200x200</option>
                <option value="300">300x300</option>
                <option value="400">400x400</option>
                <option value="500">500x500</option>
            </select>
        </div>

        <button
            onclick="generateQR()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full"
        >
            Generate QR Code
        </button>

        <div id="result" class="mt-8 text-center hidden">
            <img id="qr-image" src="" alt="QR Code" class="mx-auto border-2 border-gray-300 rounded-lg">
            <a id="download-link" href="" download="qrcode.png" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Download QR Code
            </a>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function generateQR() {
    const text = document.getElementById('qr-text').value;
    const size = document.getElementById('qr-size').value;

    if (!text) {
        alert('Please enter text or URL');
        return;
    }

    try {
        const response = await fetch('<?php echo e(route("tools.qr-code")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ text, size })
        });

        const data = await response.json();

        document.getElementById('qr-image').src = data.qr_url;
        document.getElementById('download-link').href = data.qr_url;
        document.getElementById('result').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\misc\qr-code-generator.blade.php ENDPATH**/ ?>