@extends('layouts.app')

@section('title', 'Case Converter - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Case Converter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Convert text to different cases</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your text:</label>
            <textarea
                id="input-text"
                rows="6"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Type or paste your text here..."
            ></textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <button onclick="convert('uppercase')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                UPPERCASE
            </button>
            <button onclick="convert('lowercase')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                lowercase
            </button>
            <button onclick="convert('titlecase')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Title Case
            </button>
            <button onclick="convert('sentencecase')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">
                Sentence case
            </button>
        </div>

        <div id="results" class="space-y-4 hidden">
            <div class="result-item">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">UPPERCASE:</label>
                <div class="relative">
                    <input type="text" id="result-uppercase" readonly class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button onclick="copyToClipboard('result-uppercase')" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>
            <div class="result-item">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">lowercase:</label>
                <div class="relative">
                    <input type="text" id="result-lowercase" readonly class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button onclick="copyToClipboard('result-lowercase')" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>
            <div class="result-item">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title Case:</label>
                <div class="relative">
                    <input type="text" id="result-titlecase" readonly class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white">
                    <button onclick="copyToClipboard('result-titlecase')" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function convert(type) {
    const text = document.getElementById('input-text').value;

    if (!text) {
        alert('Please enter some text');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.case-converter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text })
        });

        const data = await response.json();

        document.getElementById('result-uppercase').value = data.uppercase;
        document.getElementById('result-lowercase').value = data.lowercase;
        document.getElementById('result-titlecase').value = data.titlecase;

        document.getElementById('results').classList.remove('hidden');
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const text = element.value;
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Copied to clipboard!');
    }).catch(err => {
        element.select();
        document.execCommand('copy');
        alert('✓ Copied to clipboard!');
    });
}
</script>
@endpush
@endsection
