@extends('layouts.app')

@section('title', 'Password Generator - Toolbox')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Password Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate cryptographically secure random passwords</p>

        <div class="space-y-5 mb-6">
            {{-- Length --}}
            <div>
                <label class="flex justify-between text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    <span>Password Length</span>
                    <span id="length-value" class="text-primary-600 dark:text-primary-400 font-bold text-lg">16</span>
                </label>
                <input
                    type="range"
                    id="length"
                    min="8"
                    max="128"
                    value="16"
                    oninput="document.getElementById('length-value').textContent = this.value"
                    class="w-full accent-primary-600"
                >
                <div class="flex justify-between text-xs text-gray-400 mt-1">
                    <span>8</span><span>32</span><span>64</span><span>128</span>
                </div>
            </div>

            {{-- Character Options --}}
            <div class="grid grid-cols-2 gap-3">
                @foreach([
                    ['uppercase', 'Uppercase (A–Z)',     true],
                    ['lowercase', 'Lowercase (a–z)',     true],
                    ['numbers',   'Numbers (0–9)',       true],
                    ['symbols',   'Symbols (!@#$…)',     false],
                ] as [$id, $label, $checked])
                <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-primary-400 transition">
                    <input type="checkbox" id="{{ $id }}" {{ $checked ? 'checked' : '' }} class="w-4 h-4 accent-primary-600">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <button
            onclick="generatePassword()"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full font-medium mb-6"
        >
            🔑 Generate Password
        </button>

        <div id="result" class="hidden">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Generated Password:</label>
            <div class="relative mb-3">
                <input
                    type="text"
                    id="password"
                    readonly
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 pr-28 bg-gray-50 dark:bg-gray-700 text-lg font-mono text-gray-900 dark:text-white tracking-widest"
                >
                <button
                    onclick="copyPassword()"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary-600 text-white px-3 py-1.5 rounded-lg hover:bg-primary-700 text-sm font-medium"
                >
                    Copy
                </button>
            </div>

            {{-- Strength Bar --}}
            <div class="mb-1 flex justify-between text-xs text-gray-500">
                <span>Strength</span>
                <span id="strength-label" class="font-semibold"></span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                <div id="strength-bar" class="h-2 rounded-full transition-all duration-500"></div>
            </div>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function generatePassword() {
    const length    = parseInt(document.getElementById('length').value);
    const uppercase = document.getElementById('uppercase').checked;
    const lowercase = document.getElementById('lowercase').checked;
    const numbers   = document.getElementById('numbers').checked;
    const symbols   = document.getElementById('symbols').checked;

    if (!uppercase && !lowercase && !numbers && !symbols) {
        showError('Please select at least one character type.');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.password-generator") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ length, uppercase, lowercase, numbers, symbols })
        });

        const json = await response.json();

        if (!json.success) {
            showError(json.message);
            return;
        }

        document.getElementById('password').value = json.data.password;
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('error').classList.add('hidden');
        updateStrengthBar(json.data.strength);
    } catch (error) {
        showError('Network error. Please try again.');
    }
}

function updateStrengthBar(strength) {
    const bar   = document.getElementById('strength-bar');
    const label = document.getElementById('strength-label');
    const map   = {
        weak:   { width: '33%',  color: 'bg-red-500',    text: 'Weak',   textColor: 'text-red-500' },
        medium: { width: '66%',  color: 'bg-yellow-500', text: 'Medium', textColor: 'text-yellow-500' },
        strong: { width: '100%', color: 'bg-green-500',  text: 'Strong', textColor: 'text-green-500' },
    };
    const s = map[strength] ?? map.medium;
    bar.style.width = s.width;
    bar.className = `h-2 rounded-full transition-all duration-500 ${s.color}`;
    label.textContent = s.text;
    label.className = `font-semibold ${s.textColor}`;
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = msg;
    el.classList.remove('hidden');
}

function copyPassword() {
    const text = document.getElementById('password').value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = event.target;
        btn.textContent = 'Copied!';
        setTimeout(() => btn.textContent = 'Copy', 2000);
    });
}
</script>
@endpush
@endsection
