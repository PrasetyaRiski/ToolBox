@extends('layouts.app')

@section('title', 'Letter Counter - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Letter Counter</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Real-time character, word, sentence & paragraph counter (Unicode-safe)</p>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your text:</label>
            <textarea
                id="input-text"
                rows="10"
                oninput="count()"
                class="w-full border-2 border-gray-300 dark:border-gray-600 rounded-lg p-4 focus:border-primary-500 dark:focus:border-primary-400 focus:ring-2 focus:ring-primary-200 dark:focus:ring-primary-800 outline-none bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                placeholder="Start typing or paste your text here..."
            ></textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-primary-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400" id="char-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Characters</div>
            </div>
            <div class="bg-blue-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400" id="char-no-space-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Chars (no spaces)</div>
            </div>
            <div class="bg-violet-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-violet-600 dark:text-violet-400" id="word-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Words</div>
            </div>
            <div class="bg-green-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400" id="sentence-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Sentences</div>
            </div>
            <div class="bg-amber-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-amber-600 dark:text-amber-400" id="paragraph-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Paragraphs</div>
            </div>
            <div class="bg-rose-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-3xl font-bold text-rose-600 dark:text-rose-400" id="line-count">0</div>
                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Lines</div>
            </div>
        </div>

        <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-center text-sm text-gray-600 dark:text-gray-400">
            ⏱️ Estimated reading time: <span id="reading-time" class="font-semibold text-gray-800 dark:text-gray-200">0 sec</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
let debounceTimer = null;

function count() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(sendCount, 200);
}

async function sendCount() {
    const text = document.getElementById('input-text').value;

    // Client-side instant update for characters (no round trip needed)
    // Then confirm with server for accuracy
    try {
        const response = await fetch('{{ route("tools.letter-counter") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text })
        });

        const json = await response.json();
        if (!json.success) return;

        const d = json.data;
        document.getElementById('char-count').textContent          = d.characters.toLocaleString();
        document.getElementById('char-no-space-count').textContent = d.characters_no_spaces.toLocaleString();
        document.getElementById('word-count').textContent          = d.words.toLocaleString();
        document.getElementById('sentence-count').textContent      = d.sentences.toLocaleString();
        document.getElementById('paragraph-count').textContent     = d.paragraphs.toLocaleString();
        document.getElementById('line-count').textContent          = d.lines.toLocaleString();

        const sec = d.reading_time_sec;
        document.getElementById('reading-time').textContent =
            sec < 60 ? `${sec} sec` : `${Math.ceil(sec / 60)} min`;
    } catch (error) {
        console.error('Letter counter error:', error);
    }
}
</script>
@endpush
@endsection
