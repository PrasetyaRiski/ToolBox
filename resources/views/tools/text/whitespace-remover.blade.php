@extends('layouts.app')

@section('title', 'Whitespace Remover - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Whitespace Remover</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Clean up whitespace from your text with multiple modes</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Input:</label>
                <textarea
                    id="input-text"
                    rows="12"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                    placeholder="Paste your text with extra whitespace here..."
                ></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Output:</label>
                <textarea
                    id="output"
                    readonly
                    rows="12"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                    placeholder="Result will appear here..."
                ></textarea>
            </div>
        </div>

        {{-- Mode Buttons --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
            @foreach([
                ['normalize', '🔧 Normalize Spaces',  'bg-primary-600 hover:bg-primary-700',  'Collapse multiple spaces/tabs to one. Keeps single newlines.'],
                ['trim',      '✂️ Trim Edges',         'bg-blue-600 hover:bg-blue-700',        'Remove leading and trailing whitespace only.'],
                ['newlines',  '📄 Remove Newlines',    'bg-violet-600 hover:bg-violet-700',    'Join all lines into one. Collapses spaces.'],
                ['all',       '🧹 Remove All Spaces',  'bg-rose-600 hover:bg-rose-700',        'Remove every whitespace character including spaces, tabs, newlines.'],
            ] as [$mode, $label, $cls, $tip])
            <button
                onclick="removeWhitespace('{{ $mode }}')"
                title="{{ $tip }}"
                class="{{ $cls }} text-white px-4 py-2 rounded-lg transition text-sm font-medium"
            >{{ $label }}</button>
            @endforeach
        </div>

        <div class="flex justify-between items-center">
            <p id="stats" class="text-xs text-gray-500 dark:text-gray-400"></p>
            <button onclick="copyResult()" id="copy-btn" class="hidden text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                📋 Copy Result
            </button>
        </div>

        <div id="error" class="hidden mt-3 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function removeWhitespace(type) {
    const text = document.getElementById('input-text').value;

    if (!text) {
        showError('Please enter some text.');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.whitespace-remover") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text, type })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        const result = json.data.result;
        document.getElementById('output').value = result;
        document.getElementById('copy-btn').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');

        const removed = text.length - result.length;
        document.getElementById('stats').textContent =
            `Original: ${text.length} chars → Result: ${result.length} chars (${removed >= 0 ? '-' : '+'}${Math.abs(removed)} chars)`;
    } catch (error) {
        showError('Network error. Please try again.');
    }
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

function copyResult() {
    const text = document.getElementById('output').value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copy-btn');
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy Result', 2000);
    });
}
</script>
@endpush
@endsection
