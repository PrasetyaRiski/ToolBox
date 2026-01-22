@extends('layouts.app')

@section('title', $tool->name . ' - Toolbox')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('categories.show', $tool->category->slug) }}" class="hover:text-primary-600 dark:hover:text-primary-400">
            {{ $tool->category->name }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-900 dark:text-white">{{ $tool->name }}</span>
    </div>

    <!-- Tool Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8 mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center">
                <span class="text-4xl mr-4">{{ $tool->category->icon }}</span>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $tool->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $tool->description }}</p>
                </div>
            </div>
            @auth
            <button
                onclick="toggleFavorite({{ $tool->id }})"
                id="favorite-btn"
                class="text-2xl hover:scale-110 transition"
                title="Add to favorites"
            >
                @if(auth()->user()->favorites->contains('tool_id', $tool->id))
                    ⭐
                @else
                    ☆
                @endif
            </button>
            @endauth
        </div>

        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-4">
            <span class="mr-4">Category: {{ $tool->category->name }}</span>
            <span>Used {{ number_format($tool->usage_count) }} times</span>
        </div>
    </div>

    <!-- Tool Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Tool Interface</h2>
        <div class="text-center py-12 text-gray-600 dark:text-gray-400">
            <p>This tool's interface will be implemented based on its specific functionality.</p>
            <p class="mt-2">Check out the working tools like Case Converter, Lorem Ipsum Generator, etc.</p>
        </div>
    </div>
</div>

@auth
@push('scripts')
<script>
function toggleFavorite(toolId) {
    fetch('{{ route("favorites.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tool_id: toolId })
    })
    .then(response => response.json())
    .then(data => {
        const btn = document.getElementById('favorite-btn');
        btn.textContent = data.favorited ? '⭐' : '☆';
    });
}
</script>
@endpush
@endauth
@endsection
