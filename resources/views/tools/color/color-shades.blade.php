@extends('layouts.app')

@section('title', 'Color Shades Generator - Toolbox')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Color Shades Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate 10 shades from lightest to darkest — like Tailwind CSS palette</p>

        <div class="flex gap-4 mb-6">
            <input
                type="text"
                id="color-input"
                placeholder="#3B82F6"
                value="#3B82F6"
                oninput="syncPicker()"
                class="flex-1 border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono"
            >
            <input
                type="color"
                id="color-picker"
                value="#3B82F6"
                onchange="document.getElementById('color-input').value = this.value"
                class="w-20 h-14 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer"
            >
        </div>

        <button
            onclick="generateShades()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full mb-6 font-medium"
        >
            🎨 Generate Shades
        </button>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Shades (100–900)</h3>
                <button onclick="copyAllAsCSS()" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                    📋 Copy All as CSS Variables
                </button>
            </div>
            <div id="shades-container" class="grid grid-cols-5 md:grid-cols-10 gap-2 mb-4"></div>

            {{-- CSS Variables preview --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CSS Variables:</label>
                <textarea
                    id="css-output"
                    readonly
                    rows="6"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 bg-gray-50 dark:bg-gray-700 font-mono text-xs text-gray-900 dark:text-white"
                ></textarea>
            </div>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
let shadesData = [];

function syncPicker() {
    const val = document.getElementById('color-input').value;
    if (/^#[0-9A-Fa-f]{6}$/.test(val) || /^#[0-9A-Fa-f]{3}$/.test(val)) {
        document.getElementById('color-picker').value = val;
    }
}

async function generateShades() {
    const color = document.getElementById('color-input').value.trim();

    if (!color) {
        showError('Please enter a color.');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.color-shades") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ color })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        shadesData = json.data.shades;
        const container = document.getElementById('shades-container');
        container.innerHTML = '';

        shadesData.forEach(shade => {
            // Determine text color for readability
            const brightness = parseInt(shade.hex.slice(1, 3), 16) * 0.299
                             + parseInt(shade.hex.slice(3, 5), 16) * 0.587
                             + parseInt(shade.hex.slice(5, 7), 16) * 0.114;
            const textColor  = brightness > 128 ? '#1f2937' : '#f9fafb';

            const div = document.createElement('div');
            div.className = 'text-center cursor-pointer group';
            div.onclick   = () => copyColor(shade.hex);
            div.innerHTML = `
                <div class="w-full h-16 rounded-lg mb-1 flex items-center justify-center transition hover:scale-105 hover:shadow-lg"
                     style="background-color: ${shade.hex}; color: ${textColor};">
                    <span class="text-xs font-bold opacity-0 group-hover:opacity-100 transition">Copy</span>
                </div>
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">${shade.label}</p>
                <p class="text-xs font-mono text-gray-500 dark:text-gray-400">${shade.hex}</p>
            `;
            container.appendChild(div);
        });

        // Generate CSS variables
        const varPrefix = '--color';
        const cssVars = `:root {\n` + shadesData.map(s => `  ${varPrefix}-${s.label}: ${s.hex};`).join('\n') + `\n}`;
        document.getElementById('css-output').value = cssVars;

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
}

function copyColor(hex) {
    navigator.clipboard.writeText(hex).then(() => {
        // Brief visual feedback
        const toast = document.createElement('div');
        toast.textContent = `✓ Copied ${hex}`;
        toast.className = 'fixed bottom-4 right-4 bg-gray-900 text-white text-sm px-4 py-2 rounded-lg shadow-lg z-50 transition';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}

function copyAllAsCSS() {
    const text = document.getElementById('css-output').value;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy All as CSS Variables', 2000);
    });
}
</script>
@endpush
@endsection
