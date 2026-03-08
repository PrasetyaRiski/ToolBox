@extends('layouts.app')

@section('title', 'URL Encoder/Decoder - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">URL Encoder/Decoder</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Encode or decode URL strings</p>

        <!-- Info Box -->
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
            <p class="text-sm text-blue-800 dark:text-blue-300">
                <strong>ℹ️ Info:</strong> URL Encode mengubah karakter khusus menjadi format persen (%).
                Hasil encode <strong>tidak bisa</strong> dibuka langsung di browser, tapi digunakan sebagai parameter URL.
                <br>Contoh penggunaan: <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">https://example.com/redirect?url=<span class="text-blue-600 dark:text-blue-400">HASIL_ENCODE</span></code>
            </p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter text or URL:</label>
            <textarea
                id="input-text"
                rows="6"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Contoh: https://www.youtube.com/watch?v=abc123"
            ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <button
                onclick="process('encode')"
                class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition"
            >
                🔒 Encode URL
            </button>
            <button
                onclick="process('decode')"
                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition"
            >
                🔓 Decode URL
            </button>
        </div>

        <div id="result" class="hidden">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                <div class="flex gap-3">
                    <button onclick="openInBrowser()" id="open-btn" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 hidden">
                        🔗 Open in Browser
                    </button>
                    <button onclick="copyResult()" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        📋 Copy
                    </button>
                </div>
            </div>
            <textarea
                id="output"
                readonly
                rows="6"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
            ></textarea>

            <!-- Info setelah encode -->
            <div id="encode-info" class="hidden mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                <p class="text-sm text-yellow-800 dark:text-yellow-300">
                    ⚠️ Hasil encode ini <strong>tidak bisa</strong> dibuka langsung di browser.
                    Gunakan sebagai parameter di URL lain atau klik <strong>Decode</strong> untuk mengembalikan ke URL asli.
                </p>
            </div>

            <!-- Info setelah decode -->
            <div id="decode-info" class="hidden mt-3 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-800 dark:text-green-300">
                    ✅ URL sudah di-decode. Klik tombol <strong>"Open in Browser"</strong> untuk membuka URL.
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let lastAction = '';

async function process(action) {
    const text = document.getElementById('input-text').value;
    lastAction = action;

    if (!text) {
        alert('Please enter some text');
        return;
    }

    try {
        const response = await fetch('{{ route("tools.url-encode") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text, action })
        });

        const data = await response.json();
        document.getElementById('output').value = data.result;
        document.getElementById('result').classList.remove('hidden');

        // Tampilkan/sembunyikan info berdasarkan action
        const encodeInfo = document.getElementById('encode-info');
        const decodeInfo = document.getElementById('decode-info');
        const openBtn = document.getElementById('open-btn');

        if (action === 'encode') {
            encodeInfo.classList.remove('hidden');
            decodeInfo.classList.add('hidden');
            openBtn.classList.add('hidden');
        } else {
            encodeInfo.classList.add('hidden');
            // Tampilkan tombol Open in Browser jika hasil adalah URL valid
            if (isValidUrl(data.result)) {
                decodeInfo.classList.remove('hidden');
                openBtn.classList.remove('hidden');
            } else {
                decodeInfo.classList.add('hidden');
                openBtn.classList.add('hidden');
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    }
}

function isValidUrl(string) {
    try {
        const url = new URL(string);
        return url.protocol === 'http:' || url.protocol === 'https:';
    } catch (_) {
        return false;
    }
}

function openInBrowser() {
    const url = document.getElementById('output').value;
    if (isValidUrl(url)) {
        window.open(url, '_blank');
    } else {
        alert('Result is not a valid URL');
    }
}

function copyResult() {
    const output = document.getElementById('output');
    const text = output.value;
    navigator.clipboard.writeText(text).then(() => {
        alert('✓ Copied to clipboard!');
    }).catch(err => {
        output.select();
        document.execCommand('copy');
        alert('✓ Copied to clipboard!');
    });
}
</script>
@endpush
@endsection
