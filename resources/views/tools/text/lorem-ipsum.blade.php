@extends('layouts.app')

@section('title', 'Lorem Ipsum Generator - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Lorem Ipsum Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate realistic placeholder text for your designs</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type:</label>
                <select
                    id="type"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:border-primary-500 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
                    <option value="paragraphs">Paragraphs</option>
                    <option value="sentences">Sentences</option>
                    <option value="words">Words</option>
                </select>
            </div>

            {{-- Count --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Count: <span id="count-value" class="text-primary-600 dark:text-primary-400 font-bold">3</span>
                </label>
                <input
                    type="range"
                    id="count"
                    min="1"
                    max="20"
                    value="3"
                    oninput="document.getElementById('count-value').textContent = this.value"
                    class="w-full mt-2"
                >
            </div>
        </div>

        <button
            onclick="generate()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full font-medium mb-6"
        >
            ✨ Generate
        </button>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Generated Text:</label>
                <div class="flex gap-3">
                    <button onclick="copyResult()" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                        📋 Copy
                    </button>
                </div>
            </div>
            <textarea
                id="output"
                readonly
                rows="12"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white leading-relaxed"
            ></textarea>
            <p id="word-count" class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right"></p>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function generate() {
    const type  = document.getElementById('type').value;
    const count = document.getElementById('count').value;

    try {
        const response = await fetch('{{ route("tools.lorem-ipsum") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ type, count: parseInt(count) })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        const text = json.data.text;
        document.getElementById('output').value = text;
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');

        // Word count info
        const words = text.trim().split(/\s+/).length;
        document.getElementById('word-count').textContent = `${words} words · ${text.length} characters`;
    } catch (error) {
        showError('Network error. Please try again.');
    }
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = msg;
    el.classList.remove('hidden');
    document.getElementById('result').classList.add('hidden');
}

function copyResult() {
    const text = document.getElementById('output').value;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    });
}
</script>
@endpush
@endsection
