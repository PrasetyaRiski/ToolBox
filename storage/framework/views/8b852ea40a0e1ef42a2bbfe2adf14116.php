<?php $__env->startSection('title', 'Letter Counter - Toolbox'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Letter Counter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Count characters, words, and sentences in your text</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your text:</label>
            <textarea
                id="input-text"
                rows="10"
                oninput="count()"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Start typing or paste your text here..."
            ></textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="char-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Characters</div>
            </div>
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="char-no-space-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Characters (no spaces)</div>
            </div>
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="word-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Words</div>
            </div>
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="sentence-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Sentences</div>
            </div>
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="paragraph-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Paragraphs</div>
            </div>
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="line-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Lines</div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
async function count() {
    const text = document.getElementById('input-text').value;

    try {
        const response = await fetch('<?php echo e(route("tools.letter-counter")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ text })
        });

        const data = await response.json();

        document.getElementById('char-count').textContent = data.characters;
        document.getElementById('char-no-space-count').textContent = data.characters_no_spaces;
        document.getElementById('word-count').textContent = data.words;
        document.getElementById('sentence-count').textContent = data.sentences;
        document.getElementById('paragraph-count').textContent = data.paragraphs;
        document.getElementById('line-count').textContent = data.lines;
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kiki4\Documents\belajar web\productivitools\resources\views\tools\text\letter-counter.blade.php ENDPATH**/ ?>