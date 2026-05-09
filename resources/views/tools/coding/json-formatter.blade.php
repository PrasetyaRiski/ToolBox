@extends('layouts.app')

@section('title', 'JSON Formatter - Toolbox')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">JSON Formatter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Validate, format (pretty-print) and minify JSON</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Input JSON:</label>
                    <button onclick="clearInput()" class="text-xs text-gray-400 hover:text-gray-600">✕ Clear</button>
                </div>
                <textarea
                    id="input-json"
                    rows="16"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none font-mono text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder='{"name":"John","age":30,"city":"New York"}'
                ></textarea>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Output:</label>
                    <div class="flex gap-2 items-center">
                        <span id="valid-badge"></span>
                        <button onclick="copyResult('output')" id="copy-btn" class="hidden text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">📋 Copy</button>
                    </div>
                </div>
                <textarea
                    id="output"
                    readonly
                    rows="16"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 font-mono text-sm text-gray-900 dark:text-white"
                ></textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <button onclick="formatJSON('format')" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition font-medium">
                🖊 Format (Pretty)
            </button>
            <button onclick="formatJSON('minify')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                📦 Minify
            </button>
            <button onclick="validateOnly()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition font-medium">
                ✔ Validate Only
            </button>
        </div>

        <div id="error" class="hidden mt-4 p-4 bg-red-50 dark:bg-red-900/30 border-2 border-red-300 dark:border-red-700 rounded-lg">
            <p class="text-red-600 dark:text-red-400 font-semibold text-sm">❌ Invalid JSON</p>
            <p id="error-message" class="text-red-500 dark:text-red-400 text-sm mt-1 font-mono"></p>
        </div>
    </div>
</div>

@push('scripts')
<script>
let outputMode = 'format';

async function formatJSON(mode) {
    outputMode = mode;
    const json = document.getElementById('input-json').value.trim();

    if (!json) {
        alert('Please enter JSON.');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.json-formatter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ json })
        });

        const data = await response.json();

        if (!data.success) {
            showError(data.message);
            return;
        }

        const result = mode === 'minify' ? data.data.minified : data.data.formatted;
        document.getElementById('output').value = result;
        document.getElementById('copy-btn').classList.remove('hidden');
        document.getElementById('valid-badge').innerHTML =
            '<span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded">✓ Valid JSON</span>';
        document.getElementById('error').classList.add('hidden');
    } catch (error) {
        showError(error.message);
    }
}

async function validateOnly() {
    const json = document.getElementById('input-json').value.trim();
    if (!json) { alert('Please enter JSON.'); return; }

    try {
        const response = await fetch('{{ route("tools.json-formatter") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ json })
        });
        const data = await response.json();

        if (data.success) {
            document.getElementById('output').value = '✅ JSON is valid!';
            document.getElementById('valid-badge').innerHTML =
                '<span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded">✓ Valid</span>';
            document.getElementById('error').classList.add('hidden');
        } else {
            showError(data.message);
        }
    } catch (e) {
        showError(e.message);
    }
}

function showError(msg) {
    document.getElementById('error-message').textContent = msg;
    document.getElementById('error').classList.remove('hidden');
    document.getElementById('output').value = '';
    document.getElementById('copy-btn').classList.add('hidden');
    document.getElementById('valid-badge').innerHTML =
        '<span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300 text-xs px-2 py-1 rounded">✗ Invalid</span>';
}

function copyResult(id) {
    const text = document.getElementById(id).value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copy-btn');
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    });
}

function clearInput() {
    document.getElementById('input-json').value = '';
    document.getElementById('output').value = '';
    document.getElementById('valid-badge').innerHTML = '';
    document.getElementById('copy-btn').classList.add('hidden');
    document.getElementById('error').classList.add('hidden');
}
</script>
@endpush
@endsection
