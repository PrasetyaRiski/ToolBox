@extends('layouts.app')

@section('title', 'URL Encoder/Decoder - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">URL Encoder / Decoder</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Encode teks/URL ke format persen (%) atau decode kembali ke teks asli</p>

        {{-- Info Box --}}
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg text-sm text-blue-800 dark:text-blue-300 space-y-1">
            <p><strong>🔒 Encode:</strong> Mengubah karakter khusus (spasi, &, =, ?, dll) menjadi format <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">%XX</code>. Gunakan sebagai <em>parameter nilai</em> dalam URL.</p>
            <p><strong>🔓 Decode:</strong> Mengembalikan string <code class="bg-blue-100 dark:bg-blue-800 px-1 rounded">%XX</code> ke teks aslinya.</p>
            <p class="text-xs text-blue-600 dark:text-blue-400">
                Contoh encode: <code>https://example.com?q=hello world</code>
                → <code>https%3A%2F%2Fexample.com%3Fq%3Dhello%20world</code>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Input:</label>
                <textarea
                    id="input-text"
                    rows="10"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                    placeholder="Contoh: https://www.youtube.com/watch?v=abc123&list=xyz"
                ></textarea>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Result:</label>
                    <div class="flex gap-2 items-center">
                        <button onclick="openInBrowser()" id="open-btn" class="hidden text-sm text-green-600 dark:text-green-400 hover:text-green-700 font-medium">
                            🔗 Buka di Browser
                        </button>
                        <button onclick="copyResult()" id="copy-btn" class="hidden text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 font-medium">
                            📋 Copy
                        </button>
                    </div>
                </div>
                <textarea
                    id="output"
                    readonly
                    rows="10"
                    class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white font-mono text-sm"
                    placeholder="Hasil encode/decode muncul di sini..."
                ></textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <button
                onclick="process('encode')"
                class="bg-primary-600 text-white px-6 py-3 rounded-lg hover:bg-primary-700 transition font-medium"
            >
                🔒 Encode URL
            </button>
            <button
                onclick="process('decode')"
                class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium"
            >
                🔓 Decode URL
            </button>
        </div>

        {{-- Status Info --}}
        <div id="encode-info" class="hidden mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-800 rounded-lg text-sm text-yellow-800 dark:text-yellow-300">
            ⚠️ Hasil encode <strong>tidak bisa</strong> dibuka langsung di browser. Gunakan sebagai <em>nilai parameter</em> dalam URL lain, atau klik <strong>Decode</strong> untuk mengembalikan ke teks asli.
        </div>

        <div id="decode-info" class="hidden mt-4 p-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-300">
            ✅ URL berhasil di-decode. Klik <strong>"Buka di Browser"</strong> untuk membuka URL tersebut.
        </div>

        <div id="error" class="hidden mt-4 p-3 bg-red-50 dark:bg-red-900/30 border border-red-300 rounded-lg text-red-600 dark:text-red-400 text-sm"></div>
    </div>
</div>

@push('scripts')
<script>
async function process(action) {
    const text = document.getElementById('input-text').value;

    if (!text.trim()) {
        alert('Masukkan teks atau URL terlebih dahulu.');
        return;
    }

    // Reset UI state
    hideAll();

    try {
        const response = await fetch('{{ route("tools.url-encode") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text, action })
        });

        const json = await response.json();

        // ✅ Gunakan format response baru: json.data.result
        if (!json.success) {
            showError(json.message);
            return;
        }

        const result = json.data.result;
        document.getElementById('output').value = result;
        document.getElementById('copy-btn').classList.remove('hidden');

        if (action === 'encode') {
            document.getElementById('encode-info').classList.remove('hidden');
        } else {
            // Decode — tampilkan "Buka di Browser" hanya jika hasil adalah URL valid
            if (isValidUrl(result)) {
                document.getElementById('decode-info').classList.remove('hidden');
                document.getElementById('open-btn').classList.remove('hidden');
            }
        }
    } catch (error) {
        showError('Network error. Silakan coba lagi.');
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
        alert('Hasil bukan URL yang valid.');
    }
}

function copyResult() {
    const text = document.getElementById('output').value;
    if (!text) return;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copy-btn');
        btn.textContent = '✓ Copied!';
        setTimeout(() => btn.textContent = '📋 Copy', 2000);
    }).catch(() => {
        const el = document.getElementById('output');
        el.select();
        document.execCommand('copy');
    });
}

function showError(msg) {
    const el = document.getElementById('error');
    el.textContent = '❌ ' + msg;
    el.classList.remove('hidden');
}

function hideAll() {
    ['encode-info', 'decode-info', 'error'].forEach(id =>
        document.getElementById(id).classList.add('hidden')
    );
    document.getElementById('open-btn').classList.add('hidden');
    document.getElementById('copy-btn').classList.add('hidden');
    document.getElementById('output').value = '';
}
</script>
@endpush
@endsection
