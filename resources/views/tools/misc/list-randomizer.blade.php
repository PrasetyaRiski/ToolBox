@extends('layouts.app')

@section('title', 'List Randomizer - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">List Randomizer</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Shuffle your list or pick a random item — cryptographically random</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Your list <span id="item-count" class="text-gray-400 text-xs">(0 items)</span>
                    </label>
                    <button onclick="clearAll()" class="text-xs text-gray-400 hover:text-gray-600">✕ Clear</button>
                </div>
                <textarea
                    id="input-list"
                    rows="16"
                    oninput="updateCount()"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Apple&#10;Banana&#10;Cherry&#10;Date&#10;Elderberry"
                ></textarea>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                    <button onclick="copyResult()" id="copy-btn" class="hidden text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">📋 Copy</button>
                </div>
                <textarea
                    id="output"
                    readonly
                    rows="16"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                    placeholder="Shuffled list appears here..."
                ></textarea>
            </div>
        </div>

        {{-- Random Pick Highlight --}}
        <div id="random-pick" class="hidden mb-6">
            <div class="bg-primary-50 dark:bg-gray-700 border-2 border-primary-300 dark:border-primary-600 rounded-lg p-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">🎯 Random Pick:</p>
                <p id="random-item" class="text-3xl font-bold text-primary-600 dark:text-primary-400"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <button onclick="randomize()" class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition font-medium">
                🎲 Shuffle List
            </button>
            <button onclick="pickRandom()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium">
                🎯 Pick Random Item
            </button>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
function updateCount() {
    const list  = document.getElementById('input-list').value;
    const items = list.split('\n').filter(l => l.trim() !== '');
    document.getElementById('item-count').textContent = `(${items.length} items)`;
}

async function randomize() {
    const list = document.getElementById('input-list').value;
    if (!list.trim()) { showError('Please enter a list.'); return; }

    const response = await callApi(list, 'shuffle');
    if (!response) return;

    if (!response.success) { showError(response.message); return; }

    document.getElementById('output').value = response.data.result.join('\n');
    document.getElementById('copy-btn').classList.remove('hidden');
    document.getElementById('random-pick').classList.add('hidden');
    document.getElementById('error').classList.add('hidden');
}

async function pickRandom() {
    const list = document.getElementById('input-list').value;
    if (!list.trim()) { showError('Please enter a list.'); return; }

    const response = await callApi(list, 'pick');
    if (!response) return;

    if (!response.success) { showError(response.message); return; }

    document.getElementById('random-item').textContent = response.data.result;
    document.getElementById('random-pick').classList.remove('hidden');
    document.getElementById('output').value = '';
    document.getElementById('copy-btn').classList.add('hidden');
    document.getElementById('error').classList.add('hidden');
}

async function callApi(list, action) {
    try {
        const response = await fetch('{{ route("tools.list-randomizer") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ list, action })
        });
        return await response.json();
    } catch (error) {
        showError('Network error. Please try again.');
        return null;
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
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    });
}

function clearAll() {
    document.getElementById('input-list').value = '';
    document.getElementById('output').value = '';
    document.getElementById('random-pick').classList.add('hidden');
    document.getElementById('copy-btn').classList.add('hidden');
    document.getElementById('error').classList.add('hidden');
    document.getElementById('item-count').textContent = '(0 items)';
}
</script>
@endpush
@endsection
