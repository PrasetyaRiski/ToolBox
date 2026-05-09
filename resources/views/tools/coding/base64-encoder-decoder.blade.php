@extends('layouts.app')

@section('title', 'Base64 Encoder/Decoder - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Base64 Encoder / Decoder</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Encode plain text to Base64 or decode Base64 back to text</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Input:</label>
                <textarea
                    id="input-text"
                    rows="12"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none font-mono text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Enter text to encode, or Base64 string to decode..."
                ></textarea>
                <p class="text-xs text-gray-400 mt-1">Whitespace in Base64 input is automatically stripped before decoding.</p>
            </div>
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                    <button onclick="copyResult()" id="copy-btn" class="hidden text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">📋 Copy</button>
                </div>
                <textarea
                    id="output"
                    readonly
                    rows="12"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 font-mono text-sm text-gray-900 dark:text-white"
                    placeholder="Result appears here..."
                ></textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <button
                onclick="process('encode')"
                class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition font-medium"
            >
                🔒 Encode → Base64
            </button>
            <button
                onclick="process('decode')"
                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium"
            >
                🔓 Decode ← Base64
            </button>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function process(action) {
    const text = document.getElementById('input-text').value;

    if (!text.trim()) {
        alert('Please enter some text.');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.base64") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text, action })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        document.getElementById('output').value = json.data.result;
        document.getElementById('copy-btn').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');
    } catch (error) {
        showError('Network error. Please try again.');
    }
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = '❌ ' + msg;
    el.classList.remove('hidden');
    document.getElementById('copy-btn').classList.add('hidden');
}

function copyResult() {
    const text = document.getElementById('output').value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copy-btn');
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    });
}
</script>
@endpush
@endsection
