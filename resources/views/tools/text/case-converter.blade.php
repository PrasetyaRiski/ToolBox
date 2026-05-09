@extends('layouts.app')

@section('title', 'Case Converter - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Case Converter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Convert text to any case — supports Unicode & Bahasa Indonesia</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your text:</label>
            <textarea
                id="input-text"
                rows="6"
                oninput="autoConvert()"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Type or paste your text here..."
            ></textarea>
        </div>

        {{-- Mode Buttons --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6" id="mode-buttons">
            @foreach([
                ['uppercase',    'UPPERCASE',     'bg-blue-600 hover:bg-blue-700'],
                ['lowercase',    'lowercase',     'bg-indigo-600 hover:bg-indigo-700'],
                ['titlecase',    'Title Case',    'bg-violet-600 hover:bg-violet-700'],
                ['sentencecase', 'Sentence case', 'bg-purple-600 hover:bg-purple-700'],
                ['alternating',  'aLtErNaTiNg',  'bg-pink-600 hover:bg-pink-700'],
                ['camelcase',    'camelCase',     'bg-rose-600 hover:bg-rose-700'],
                ['pascalcase',   'PascalCase',    'bg-orange-600 hover:bg-orange-700'],
                ['snakecase',    'snake_case',    'bg-amber-600 hover:bg-amber-700'],
                ['kebabcase',    'kebab-case',    'bg-green-600 hover:bg-green-700'],
            ] as [$mode, $label, $cls])
            <button
                id="btn-{{ $mode }}"
                onclick="selectMode('{{ $mode }}')"
                class="{{ $cls }} text-white px-4 py-2 rounded-lg transition font-medium"
            >{{ $label }}</button>
            @endforeach
        </div>

        {{-- Result --}}
        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                <button onclick="copyResult()" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 text-sm font-medium">
                    📋 Copy
                </button>
            </div>
            <textarea
                id="output"
                readonly
                rows="6"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
            ></textarea>
        </div>

        {{-- Error --}}
        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
let currentMode = 'uppercase';
let debounceTimer = null;

function selectMode(mode) {
    currentMode = mode;
    const text = document.getElementById('input-text').value;
    if (text.trim()) convert();
}

function autoConvert() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        const text = document.getElementById('input-text').value;
        if (text.trim()) convert();
    }, 300);
}

async function convert() {
    const text = document.getElementById('input-text').value;
    if (!text.trim()) return;

    try {
        const response = await fetch('{{ route("tools.case-converter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        document.getElementById('output').value = json.data[currentMode] ?? '';
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');
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
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    }).catch(() => {
        const el = document.getElementById('output');
        el.select();
        document.execCommand('copy');
    });
}
</script>
@endpush
@endsection
