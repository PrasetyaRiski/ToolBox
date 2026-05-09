@extends('layouts.app')

@section('title', 'RGBA to HEX Converter - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">RGBA to HEX Converter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Convert RGBA color values to HEX format</p>

        <div class="grid grid-cols-4 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Red (0-255):</label>
                <input
                    type="number"
                    id="red"
                    value="255"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Green (0-255):</label>
                <input
                    type="number"
                    id="green"
                    value="87"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blue (0-255):</label>
                <input
                    type="number"
                    id="blue"
                    value="51"
                    min="0"
                    max="255"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alpha (0-1):</label>
                <input
                    type="number"
                    id="alpha"
                    value="1"
                    min="0"
                    max="1"
                    step="0.1"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                >
            </div>
        </div>

        <button
            onclick="convert()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6"
        >
            Convert to HEX
        </button>

        <div id="result" class="hidden space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HEX (#RRGGBB):</label>
                    <div class="relative">
                        <input type="text" id="hex-output" readonly
                            class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono tracking-widest">
                        <button onclick="copyValue('hex-output')" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700">
                            📋 Copy
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HEX8 (#RRGGBBAA, with alpha):</label>
                    <div class="relative">
                        <input type="text" id="hex8-output" readonly
                            class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono tracking-widest">
                        <button onclick="copyValue('hex8-output')" class="absolute right-2 top-1/2 -translate-y-1/2 text-primary-600 dark:text-primary-400 hover:text-primary-700">
                            📋 Copy
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color Preview:</label>
                <div id="color-preview" class="w-full h-24 border-2 border-gray-300 dark:border-gray-600 rounded-lg"></div>
            </div>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function convert() {
    const r = document.getElementById('red').value;
    const g = document.getElementById('green').value;
    const b = document.getElementById('blue').value;
    const a = document.getElementById('alpha').value;

    try {
        const response = await fetch('{{ route("tools.rgba-to-hex") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ r, g, b, a })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        // ✅ Format baru: json.data.hex & json.data.hex8
        const d = json.data;
        document.getElementById('hex-output').value  = d.hex;
        document.getElementById('hex8-output').value = d.hex8;
        document.getElementById('color-preview').style.backgroundColor = `rgba(${r}, ${g}, ${b}, ${a})`;
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');
    } catch (error) {
        showError('Network error. Please try again.');
    }
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = '❌ ' + msg;
    el.classList.remove('hidden');
    document.getElementById('result').classList.add('hidden');
}

function copyValue(id) {
    const text = document.getElementById(id).value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        const orig = btn.textContent;
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = orig, 2000);
    });
}
</script>
@endpush
@endsection
