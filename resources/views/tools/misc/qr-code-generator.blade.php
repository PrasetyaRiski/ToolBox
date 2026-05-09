@extends('layouts.app')

@section('title', 'QR Code Generator - Toolbox')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">QR Code Generator</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Generate scannable QR codes dari teks atau URL apapun</p>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Teks atau URL:</label>
            <textarea
                id="qr-text"
                rows="3"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="https://example.com atau teks apapun..."
            ></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ukuran (px):</label>
                <select id="qr-size" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:border-primary-500 dark:focus:border-primary-400 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="150">150 × 150</option>
                    <option value="200" selected>200 × 200</option>
                    <option value="300">300 × 300</option>
                    <option value="400">400 × 400</option>
                    <option value="500">500 × 500</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Error Correction:</label>
                <select id="qr-ecc" class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-3 focus:border-primary-500 dark:focus:border-primary-400 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="L">L — Low (7%)</option>
                    <option value="M" selected>M — Medium (15%)</option>
                    <option value="Q">Q — Quartile (25%)</option>
                    <option value="H">H — High (30%)</option>
                </select>
            </div>
        </div>

        <button
            onclick="generateQR()"
            id="generate-btn"
            class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition w-full font-medium mb-6"
        >
            📱 Generate QR Code
        </button>

        {{-- Loading State --}}
        <div id="loading" class="hidden text-center py-8">
            <div class="inline-block w-10 h-10 border-4 border-primary-600 border-t-transparent rounded-full animate-spin mb-3"></div>
            <p class="text-sm text-gray-600 dark:text-gray-400">Generating QR Code...</p>
        </div>

        {{-- Result --}}
        <div id="result" class="hidden text-center">
            <div class="inline-block p-4 bg-white rounded-xl border-2 border-gray-200 dark:border-gray-600 mb-4 shadow-sm">
                <img
                    id="qr-image"
                    src=""
                    alt="QR Code"
                    class="block mx-auto"
                    onload="onQRLoaded()"
                    onerror="onQRError()"
                >
            </div>

            <p id="qr-content" class="text-xs text-gray-500 dark:text-gray-400 mb-4 truncate max-w-full px-4"></p>

            <div class="flex gap-3 justify-center">
                <a
                    id="download-link"
                    href=""
                    download="qrcode.png"
                    target="_blank"
                    class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium"
                >
                    ⬇️ Download PNG
                </a>
                <button
                    onclick="generateQR()"
                    class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition text-sm font-medium"
                >
                    🔄 Regenerate
                </button>
            </div>
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function generateQR() {
    const text = document.getElementById('qr-text').value.trim();
    const size = document.getElementById('qr-size').value;
    const ecc  = document.getElementById('qr-ecc').value;

    if (!text) {
        alert('Masukkan teks atau URL terlebih dahulu.');
        return;
    }

    // Show loading, hide result & error
    document.getElementById('loading').classList.remove('hidden');
    document.getElementById('result').classList.add('hidden');
    document.getElementById('error').classList.add('hidden');
    document.getElementById('generate-btn').disabled = true;

    try {
        const response = await fetch('{{ route("tools.qr-code") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text, size, ecc })
        });

        const json = await response.json();

        document.getElementById('loading').classList.add('hidden');
        document.getElementById('generate-btn').disabled = false;

        if (!json.success) {
            showError(json.message);
            return;
        }

        // ✅ Format baru: json.data.qr_url
        const qrUrl = json.data.qr_url;
        document.getElementById('qr-image').src         = qrUrl;
        document.getElementById('download-link').href   = qrUrl;
        document.getElementById('qr-content').textContent = text.length > 80
            ? text.substring(0, 80) + '...'
            : text;

        // result akan tampil setelah gambar onload
    } catch (error) {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('generate-btn').disabled = false;
        showError('Network error. Pastikan koneksi internet aktif dan coba lagi.');
    }
}

function onQRLoaded() {
    document.getElementById('result').classList.remove('hidden');
    document.getElementById('error').classList.add('hidden');
}

function onQRError() {
    showError('Gagal memuat QR Code. Periksa koneksi internet dan coba lagi.');
    document.getElementById('result').classList.add('hidden');
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = '❌ ' + msg;
    el.classList.remove('hidden');
}
</script>
@endpush
@endsection
